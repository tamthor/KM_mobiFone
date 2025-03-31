@extends('layouts.master')

@section('content')
    <div class="back-button mt-4">
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
            ← Quay lại
        </a>
    </div>

    <h1 class="mb-4 mt-4">Chỉnh sửa Banner</h1>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-4 mt-4">
            <input type="text" name="title" class="form-control post-title" placeholder="Tiêu đề ..." value="{{ old('title', $banner->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label><br>
            <img src="{{ asset('storage/' . $banner->image) }}" width="150">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Cập nhật Hình ảnh</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Liên kết (tuỳ chọn)</label>
            <input type="url" name="link" class="form-control" placeholder="Nhập liên kết ..." value="{{ old('link', $banner->link) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nút hành động -->
        <div class="form-actions d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script></script>
@endsection