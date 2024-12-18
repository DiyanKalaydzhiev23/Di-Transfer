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
                <div class="flex justify-center hidden results">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                             width="100" height="100" viewBox="0 0 256 256" xml:space="preserve">
                            <defs>
                            </defs>
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                               transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                <path
                                    d="M 49.66 1.125 L 49.66 1.125 c 4.67 -2.393 10.394 -0.859 13.243 3.548 l 0 0 c 1.784 2.761 4.788 4.495 8.071 4.66 l 0 0 c 5.241 0.263 9.431 4.453 9.694 9.694 v 0 c 0.165 3.283 1.899 6.286 4.66 8.071 l 0 0 c 4.407 2.848 5.941 8.572 3.548 13.242 l 0 0 c -1.499 2.926 -1.499 6.394 0 9.319 l 0 0 c 2.393 4.67 0.859 10.394 -3.548 13.242 l 0 0 c -2.761 1.784 -4.495 4.788 -4.66 8.071 v 0 c -0.263 5.241 -4.453 9.431 -9.694 9.694 h 0 c -3.283 0.165 -6.286 1.899 -8.071 4.66 l 0 0 c -2.848 4.407 -8.572 5.941 -13.242 3.548 l 0 0 c -2.926 -1.499 -6.394 -1.499 -9.319 0 l 0 0 c -4.67 2.393 -10.394 0.859 -13.242 -3.548 l 0 0 c -1.784 -2.761 -4.788 -4.495 -8.071 -4.66 h 0 c -5.241 -0.263 -9.431 -4.453 -9.694 -9.694 l 0 0 c -0.165 -3.283 -1.899 -6.286 -4.66 -8.071 l 0 0 C 0.266 60.054 -1.267 54.33 1.125 49.66 l 0 0 c 1.499 -2.926 1.499 -6.394 0 -9.319 l 0 0 c -2.393 -4.67 -0.859 -10.394 3.548 -13.242 l 0 0 c 2.761 -1.784 4.495 -4.788 4.66 -8.071 l 0 0 c 0.263 -5.241 4.453 -9.431 9.694 -9.694 l 0 0 c 3.283 -0.165 6.286 -1.899 8.071 -4.66 l 0 0 c 2.848 -4.407 8.572 -5.941 13.242 -3.548 l 0 0 C 43.266 2.624 46.734 2.624 49.66 1.125 z"
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,131,249); fill-rule: nonzero; opacity: 1;"
                                    transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                <polygon points="36.94,66.3 36.94,66.3 36.94,46.9 36.94,46.9 62.8,35.34 72.5,45.04 "
                                         style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,119,227); fill-rule: nonzero; opacity: 1;"
                                         transform="  matrix(1 0 0 1 0 0) "/>
                                <polygon points="36.94,66.3 17.5,46.87 27.2,37.16 36.94,46.9 60.11,23.7 69.81,33.39 "
                                         style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                         transform="  matrix(1 0 0 1 0 0) "/>
                            </g>
                    </svg>
                        <h1 class="text-center text-2xl font-bold mt-4 text-blue-400">All set!</h1>
                    </div>
                </div>

                <div class="flex gap-3 border hover:border-blue-400 -mt-10 hidden rounded-md p-4 results">
                    <p class="truncate url-placeholder"></p>
                    <img height="20px" width="20px" id="copyIcon" src="/images/copy.png"/>
                </div>

                @csrf
                <div id="file-list" class="flex flex-col space-y-2 text-sm overflow-y-auto max-h-64 overflow-x-auto mb-2 max-w-full pr-2 upload">
                    <!-- File items will be appended here -->
                </div>

                <div class="flex items-center justify-center w-full mb-4 upload">
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

                <div class="upload">
                    <div class="no-space hidden" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">Oops!</div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>Hey, memory costs money. That file was too big.</p>
                        </div>
                    </div>
                    <div class="progress-bar flex justify-between mt-5 mr-1">
                        <p class="progress-bar-left-text">Space left:</p>
                        <p id="space-left" class="progress-bar-right-text">2 GB</p>
                    </div>
                    <div class="progress-bar-filled w-full h-6 bg-gray-200 rounded-md dark:bg-gray-700">
                        <div id="progress-bar" class="h-6 bg-blue-600 rounded-md dark:bg-blue-500" style="width: 0"></div>
                    </div>
                </div>

                <button type="button" class="upload" onclick="zipAndUpload()">Get a link</button>
            </form>
            <img src="{{ asset('images/image-2.png') }}" alt="" class="image-2">
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
    <script src="{{ asset('js/copy_to_clipboard.js') }}"></script>

@endsection
