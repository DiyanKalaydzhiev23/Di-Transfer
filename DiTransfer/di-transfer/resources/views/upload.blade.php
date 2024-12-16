@extends('base')

@section('title', 'Upload | DiTransfer')

@section('content')
    <script src="{{ asset('js/file_add_handling.js') }}"></script>
    <script src="{{ asset('js/zip_creation.js') }}"></script>
    <script src="{{ asset('js/zip_upload.js') }}"></script>
    <script src="{{ asset('js/send_cloudinary_url_to_be.js') }}"></script>

    <div class="wrapper">
        <div class="inner">
            <img src="/images/image-1.png" alt="" class="image-1">
            <form id="upload-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="file-list" class="flex flex-col space-y-2 text-sm overflow-y-auto max-h-64 overflow-x-auto mb-2 max-w-full pr-2">
                    <!-- File items will be appended here -->
                </div>

                <div class="flex items-center justify-center w-full mb-4">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white-50 hover:bg-gray-100 hover:border-blue-300 flex-grow min-w-[50%]">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">(You can attach multiple files)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="files[]" multiple onchange="addFiles(event)" />
                    </label>
                </div>

                <div>
                    <div class="no-space hidden" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">Oops!</div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Hey, memory costs money. That file was too big.</p>
                        </div>
                    </div>
                    <div class="progress-bar flex justify-between mt-5 mr-1">
                        <p>Space left:</p>
                        <p id="space-left">2 GB</p>
                    </div>
                    <div class="progress-bar-filled w-full h-6 bg-gray-200 rounded-md dark:bg-gray-700">
                        <div id="progress-bar" class="h-6 bg-blue-600 rounded-md dark:bg-blue-500" style="width: 0"></div>
                    </div>
                </div>

                <button type="button" onclick="zipAndUpload()">Get a link</button>
            </form>
            <img src="{{ asset('images/image-2.png') }}" alt="" class="image-2">
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>

@endsection
