@extends('layouts.master')
@section('css')
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endsection
@section('content')
    <div class="back-button">
        <a href="{{ route('admin.promotion.index') }}" class="btn btn-secondary mt-3 mb-3">← Quay lại</a>
    </div>

    <h1 class="mb-4">Chỉnh sửa khuyến mãi</h1>

    <form action="{{ route('admin.promotion.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-4">
            <input type="text" name="title" class="form-control" placeholder="Tiêu đề ..."
                value="{{ $promotion->title }}" required>
        </div>
        <div class="form-group mb-4">
            <select id="tags" name="tag_titles[]" multiple class="form-control">
                @php
                    $selectedTagIds = explode(';', $promotion->tag_ids);
                @endphp
                @if (!empty($tags))
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->title }}" {{ in_array($tag->id, $selectedTagIds) ? 'selected' : '' }}>
                            {{ $tag->title }}
                        </option>
                    @endforeach
                @endif
            </select>
            <span class="help-span">Tối đa 5 tag</span>
        </div>

        <!-- Danh mục -->
        <div class="form-group mb-4">
            <label for="category_id" class="form-label">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Chọn danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $promotion->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Thumbnail -->
        <div class="form-group mb-4">
            <label>Ảnh bìa</label>
            <textarea name="image" id="thumbnailEditor" class="form-control" placeholder="Chọn ảnh bìa">
                @if (!empty($promotion->image))
<img src="{{ $promotion->image }}" alt="Thumbnail">
@endif
            </textarea>
        </div>

        <div class="form-group mb-4">
            <textarea name="content" id="editor" class="form-control" placeholder="Nội dung bài viết">{{ $promotion->content }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_at" class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_at" id="start_at" class="form-control"
                value="{{ old('start_at', !empty($promotion->start_at) ? \Carbon\Carbon::parse($promotion->start_at)->format('Y-m-d') : '') }}">

            @error('start_at')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Ngày kết thúc --}}
        <div class="mb-3">
            <label for="end_at" class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_at" id="end_at" class="form-control"
                value="{{ old('end_at', !empty($promotion->end_at) ? \Carbon\Carbon::parse($promotion->end_at)->format('Y-m-d') : '') }}">

            @error('end_at')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="status">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ $promotion->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ $promotion->status == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
@section('scripts')
    <!-- Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- CKEditor -->
    <script src="{{ asset('js/js/ckeditor.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            /** ✅ Khởi tạo CKEditor cho thumbnail */
            const thumbnailEditor = document.querySelector('#thumbnailEditor');
            if (thumbnailEditor) {
                ClassicEditor.create(thumbnailEditor, {
                        ckfinder: {
                            uploadUrl: '{{ route('admin.upload.ckeditor') . '?_token=' . csrf_token() }}'
                        },
                        toolbar: ['imageUpload', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
                            '|', 'undo', 'redo'
                        ],
                        removePlugins: ['MediaEmbed', 'Table', 'TableToolbar', 'ImageToolbar', 'ImageResize'],
                        height: 200,
                        image: {
                            toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft',
                                'imageStyle:alignRight', 'imageStyle:alignCenter', 'imageStyle:side', '|',
                                'imageStyle:inline', 'imageStyle:block', '|', 'imageStyle:remove'
                            ]
                        }
                    })
                    .then(editor => {
                        console.log("CKEditor thumbnail đã khởi tạo thành công", editor);
                    })
                    .catch(error => {
                        console.error("Lỗi CKEditor thumbnail:", error);
                    });
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
                            tomSelect.addOption({
                                value: tagId,
                                text: tagName
                            });
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
