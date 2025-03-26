@extends('layouts.master')

@section('content')
    <div class="back-button mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Quay lại
        </a>
    </div>

    <h1 class="mb-4 mt-4">Thêm danh mục mới</h1>

    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-4 mt-4">
            <input type="text" name="title" class="form-control post-title" placeholder="Tiêu đề ..." required>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nút hành động -->
        <div class="form-actions d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Thêm danh mục</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script></script>
@endsection
