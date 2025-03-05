@extends('layouts.master')
@section('css')
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endsection

@section('content')
    <div class="back-button">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Quay lại
        </a>
    </div>

    <h1 class="mb-4">Thêm bài viết mới</h1>

    <form action="{{ route('admin.promotion.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-4 mt-4">
            <input type="text" name="title" class="form-control post-title" placeholder="Tiêu đề ..." required>
        </div>

        <!-- Thẻ bài viết -->
        <div class="form-group mb-4">
            <select id="tags" name="tags[]" multiple class="form-control">
                @if (!empty($tags))
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                @endif
            </select>
            <span class="help-span">Tối đa 5 tag</span>
        </div>

        <!-- Nội dung bài viết -->
        <div class="form-group mb-4">
            <textarea name="content" id="editor" class="form-control" placeholder="Nội dung bài viết"></textarea>
        </div>

        <!-- Nút hành động -->
        <div class="form-actions d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Đăng bài</button>
        </div>
    </form>
@endsection

@section('scripts')
    <!-- Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- CKEditor -->
    <script src="{{ asset('js/js/ckeditor.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            /** ✅ Kiểm tra tồn tại của phần tử trước khi khởi tạo CKEditor */
            const editorElement = document.querySelector('#editor');
            if (editorElement) {
                ClassicEditor.create(editorElement, {
                    ckfinder: {
                        uploadUrl: '{{ route('admin.upload.ckeditor') . '?_token=' . csrf_token() }}'
                    },
                    mediaEmbed: {
                        previewsInData: true
                    },
                    enterMode: 'BR',
                    filebrowserUploadMethod: 'form',
                })
                .then(editor => {
                    console.log("CKEditor đã khởi tạo thành công", editor);
                })
                .catch(error => {
                    console.error("Lỗi CKEditor:", error);
                });
            } else {
                console.error("Không tìm thấy #editor để khởi tạo CKEditor.");
            }

            /** ✅ Kiểm tra tồn tại của phần tử trước khi khởi tạo TomSelect */
            const tagSelect = document.querySelector("#tags");
            if (tagSelect) {
                let tomSelect = new TomSelect(tagSelect, {
                    create: true,
                    maxItems: 5,
                    placeholder: "Thêm tags",
                    onItemAdd: function(value) {
                        if (this.items.length > 5) {
                            alert("Bạn chỉ được chọn tối đa 5 tags.");
                            this.removeItem(value);
                        }
                    }
                });

                // Thêm sự kiện click cho các nút tag nếu có
                document.querySelectorAll('.tag-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const tagId = this.getAttribute('data-tag-id');
                        const tagName = this.getAttribute('data-tag-name');

                        if (!tomSelect.options[tagId]) {
                            tomSelect.addOption({ value: tagId, text: tagName });
                        }
                        tomSelect.addItem(tagId);
                    });
                });
            } else {
                console.error("Không tìm thấy #tags để khởi tạo TomSelect.");
            }
        });
    </script>
@endsection
