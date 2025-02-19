<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\LearningPageAssignmentTrait;
use App\Http\Controllers\Web\traits\LearningPageForumTrait;
use App\Http\Controllers\Web\traits\LearningPageItemInfoTrait;
use App\Http\Controllers\Web\traits\LearningPageMixinsTrait;
use App\Http\Controllers\Web\traits\LearningPageNoticeboardsTrait;
use App\Models\Certificate;
use App\Models\CourseNoticeboard;
use App\Models\File;
use Illuminate\Http\Request;

class LearningPageController extends Controller
{
    use LearningPageMixinsTrait,
        LearningPageAssignmentTrait,
        LearningPageItemInfoTrait,
        LearningPageNoticeboardsTrait,
        LearningPageForumTrait;

    public function index(Request $request, $slug)
    {
        $requestData = $request->all();

        $webinarController = new WebinarController();

        $data = $webinarController->course($slug, true);

        $course = $data['course'];
        $user = $data['user'];

        $installmentLimitation = $webinarController->installmentContentLimitation($user, $course->id, 'webinar_id');
        if ($installmentLimitation != "ok") {
            return $installmentLimitation;
        }


        if (!$data or (!$data['hasBought'] and empty($course->getInstallmentOrder()))) {
            abort(403);
        }

        if (!empty($requestData['type']) and $requestData['type'] == 'assignment' and !empty($requestData['item'])) {

            $assignmentData = $this->getAssignmentData($course, $requestData);

            $data = array_merge($data, $assignmentData);
        }

        if ($course->creator_id != $user->id and $course->teacher_id != $user->id and !$user->isAdmin()) {
            $unReadCourseNoticeboards = CourseNoticeboard::where('webinar_id', $course->id)
                ->whereDoesntHave('noticeboardStatus', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count();

            if ($unReadCourseNoticeboards) {
                $url = $course->getNoticeboardsPageUrl();
                return redirect($url);
            }
        }

        if ($course->certificate) {
            $data["courseCertificate"] = Certificate::where('type', 'course')
                ->where('student_id', $user->id)
                ->where('webinar_id', $course->id)
                ->first();
        }

        $data["otherCourses"] = File::whereIn('file_type', File::$videoTypes)
            ->whereIn('storage', config('jiujitsu.supported_videos_storage'))
            ->select(
                'files.id',
                'files.webinar_id',
                'files.chapter_id',
                'files.file',
                'files.accessibility',
                'file_translations.title',
                'files.file_type',
                'webinars.slug',
                'webinar_translations.title as webinar_name',
                'webinars.price',
                'webinars.thumbnail',
                'webinars.id as webinars_id',
            )
            ->join('webinars', 'webinars.id', '=', 'files.webinar_id')
            ->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
            ->join('file_translations', 'file_translations.file_id', '=', 'files.id')
            ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')

            ->where('webinars.status', File::$Active)
            ->where('webinar_chapters.status', File::$Active)
            ->where('files.status', File::$Active)
            ->where('file_translations.locale', 'en')
            ->where('webinar_translations.locale', 'en')
            ->where('webinars.slug', '!=', $slug)

            ->orderBy('files.id', 'desc')
            ->paginate(30);

        return view('web.jiujitsu.course.learningPage.index', $data);
    }
}
