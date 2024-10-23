<div id="stream-player" class="player stream-player grow relative">
    @if($notStarted)
        <div id="notStartedAlert" class="no-result default-no-result flex items-center justify-center flex-col w-full h-100">
            <div class="no-result-logo">
                <img src="/assets/default/img/no-results/support.png" alt="">
            </div>
            <div class="flex items-center flex-col mt-6 text-center">
                <h2 class="text-dark-blue">{{ trans('update.this_live_has_not_started_yet') }}</h2>
                <p class="mt-5 text-center text-slate-500 font-medium">{{ trans('update.this_live_has_not_started_yet_hint') }}</p>
            </div>
        </div>
    @else
        <div class="agora-stream-loading">
            <img src="/assets/default/img/loading.gif" alt="">
            <p class="mt-10">{{ trans('update.wait_to_join_the_channel') }}</p>
        </div>
    @endif

    <div id="remote-stream-player" class="remote-stream-box"></div>
</div>

<!-- Single button -->
<div class="stream-footer py-20 px-15 px-lg-30 mt-15 flex items-center justify-content-around bg-white">

    @if($sessionStreamType == 'multiple')
        <button type="button" id="microphoneEffect" class="stream-bottom-actions btn-ghost flex flex-col items-center active">
            <span class="icon">
                <i data-feather="mic" width="24" height="24" class=""></i>
            </span>

            <span class="mt-1 text-slate-500 text-sm">{{ trans('update.microphone') }}</span>
        </button>


        <button type="button" id="cameraEffect" class="stream-bottom-actions btn-ghost flex flex-col items-center active">
            <span class="icon">
                <i data-feather="video" width="24" height="24" class=""></i>
            </span>

            <span class="mt-1 text-slate-500 text-sm">{{ trans('update.camera') }}</span>
        </button>
    @endif

    <div class="stream-bottom-actions flex flex-col items-center">
        <i data-feather="clock" width="24" height="24" class=""></i>
        <span id="streamTimer" class="mt-1 text-sm text-slate-500 flex items-center justify-center">
            <span class="flex items-center justify-center text-dark time-item hours">00</span>:
            <span class="flex items-center justify-center text-dark time-item minutes">00</span>:
            <span class="flex items-center justify-center text-dark time-item seconds">00</span>
        </span>
    </div>

    @if($isHost)
        <button type="button" id="shareScreen" class="stream-bottom-actions btn-ghost flex flex-col items-center ">
            <i data-feather="airplay" width="24" height="24" class=""></i>
            <span class="mt-1 text-slate-500 text-sm">{{ trans('update.share_screen') }}</span>
        </button>

        <button type="button" id="endShareScreen" class="stream-bottom-actions btn-ghost flex-col items-center dont-join-users hidden">
            <div class="icon-box">
                <i data-feather="airplay" width="24" height="24" class=""></i>
            </div>
            <span class="mt-1 text-slate-500 text-sm">{{ trans('update.end_share_screen') }}</span>
        </button>

        <button type="button" id="handleUsersJoin" class="stream-bottom-actions btn-ghost flex flex-col items-center {{ (!empty($session->agora_settings) and !empty($session->agora_settings->users_join) and $session->agora_settings->users_join) ? '' : 'dont-join-users' }}">
            <div class="icon-box">
                <i data-feather="users" width="24" height="24" class=""></i>
            </div>
            <span class="mt-1 text-slate-500 text-sm">{{ (!empty($session->agora_settings) and !empty($session->agora_settings->users_join) and $session->agora_settings->users_join) ? trans('update.join_is_active') : trans('update.joining_is_disabled') }}</span>
        </button>

        <button type="button" class="stream-bottom-actions btn-ghost flex flex-col items-center text-danger" data-toggle="modal" data-target="#leaveModal">
            <i data-feather="x-square" width="24" height="24" class=" "></i>
            <span class="mt-1 text-sm">{{ trans('update.end_live') }}</span>
        </button>

        <div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="leaveModalLabel">{{ trans('update.end_live') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <p class="">{{ trans('update.end_live_confirm') }}</p>

                        <div class="mt-6 text-center">
                            <button type="button" class="btn bg-red-600 text-white btn-sm" id="leave" data-id="{{ $session->id }}">{{ trans('admin/main.yes') }}</button>
                            <button type="button" class="btn ml-10 btn-gray btn-sm" data-dismiss="modal">{{ trans('admin/main.close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts_bottom')
    <script>
        var rtcToken = '{{ $rtcToken }}';
        var joinIsActiveLang = '{{ trans('update.join_is_active') }}';
        var joiningIsDisabledLang = '{{ trans('update.joining_is_disabled') }}';
        var notStarted = false;
        @if($notStarted) notStarted = true @endif

    </script>
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>

    <script src="/assets/vendors/agora/AgoraRTC_N.js"></script>
    <script src="/assets/default/agora/stream.min.js"></script>
@endpush

