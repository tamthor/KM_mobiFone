@extends('layouts.master')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Quản lý Banners
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary shadow-md mr-2">Thêm Banner</a>
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">HÌNH ẢNH</th>
                        <th class="text-center whitespace-nowrap">TRẠNG THÁI</th>
                        <th class="text-center whitespace-nowrap">HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">{{ $banner->title }}</td>
                            <td class="text-center">
                                <img src="{{ asset( $banner->image) }}" class="w-auto max-w-[140px] h-[70px]" alt="{{ $banner->title }}">
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center {{ $banner->status == 'active' ? 'text-success' : 'text-danger' }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>
                                    {{ ucfirst($banner->status) }}
                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ route('admin.banners.edit', $banner->id) }}"> 
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit 
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-danger"> 
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete 
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center" id="pagination-links">
            {{ $banners->links() }}
        </div>
    </div>
@endsection