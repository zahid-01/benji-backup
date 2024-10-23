<div class="product-show-files-tab mt-4">
    @if(!empty($product->files) and count($product->files) and $product->checkUserHasBought())
        @foreach($product->files as $productFile)
            <div class="flex items-center justify-between p-15 p-lg-20 bg-white rounded-sm border border-gray200 {{ ($loop->iteration > 1) ? 'mt-15' : '' }}">
                <div class="">
                    <span class="block font-16 font-bold text-dark-blue">{{ $productFile->title }}</span>
                    <span class="block text-sm text-slate-500">{{ $productFile->description }}</span>
                </div>

                <div class="flex items-center ml-20">

                    @if($productFile->online_viewer)
                        <button type="button" data-href="{{ $productFile->getOnlineViewUrl() }}"  class="js-online-show product-file-download-btn flex items-center justify-center text-white border-0 rounded-full mr-15">
                            <i data-feather="eye" width="20" height="20" class=""></i>
                        </button>
                    @endif

                    <a href="{{ $productFile->getDownloadUrl() }}" target="_blank" class="product-file-download-btn flex items-center justify-center text-white rounded-full">
                        <i data-feather="download" width="20" height="20" class=""></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
