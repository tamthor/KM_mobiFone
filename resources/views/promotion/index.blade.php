@extends('layouts.master')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Promotion List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.promotion.create') }}" class="btn btn-primary shadow-md mr-2">Add New Promotion</a>
            <div class="hidden md:block mx-auto text-slate-500">Showing {{ $promotions->firstItem() }} to {{ $promotions->lastItem() }} of {{ $promotions->total() }} entries</div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form method="GET" action="{{ route('admin.promotion.index') }}">
                    <div class="w-56 relative text-slate-500">
                        <input type="text" name="search" class="form-control w-56 box pr-10" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                            <i class="w-4 h-4" data-lucide="search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">TITLE</th>
                        <th class="text-center whitespace-nowrap">START DATE</th>
                        <th class="text-center whitespace-nowrap">END DATE</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promotions as $promotion)
                    <tr class="intro-x"> 
                        <td>
                            <a href="{{ route('admin.promotion.edit', $promotion->id) }}" class="font-medium whitespace-nowrap">{{ $promotion->title }}</a>
                        </td>
                        <td class="text-center">
                            {{ $promotion->start_at ? \Carbon\Carbon::parse($promotion->start_at)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-center">
                            {{ $promotion->end_at ? \Carbon\Carbon::parse($promotion->end_at)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="w-40">
                            <div class="flex items-center justify-center {{ $promotion->status == 'active' ? 'text-success' : 'text-danger' }}"> 
                                <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> 
                                {{ ucfirst($promotion->status) }} 
                            </div>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.promotion.edit', $promotion->id) }}"> 
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit 
                                </a>
                                <form action="{{ route('admin.promotion.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
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
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $promotions->links() }}
        </div>
    </div>
@endsection
