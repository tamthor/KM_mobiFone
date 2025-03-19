@extends('layouts.master')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Contact List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="hidden md:block mx-auto text-slate-500">
                Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} entries
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form method="GET" action="{{ route('admin.contact.index') }}">
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
                        <th class="whitespace-nowrap">FULL NAME</th>
                        <th class="text-center whitespace-nowrap">PHONE</th>
                        <th class="text-center whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">CITY</th>
                        <th class="text-center whitespace-nowrap">NOTE</th>
                        <th class="text-center whitespace-nowrap">CONTENT TITLE</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">{{ $contact->full_name }}</td>
                        <td class="text-center">{{ $contact->phone_number }}</td>
                        <td class="text-center">{{ $contact->email ?? 'N/A' }}</td>
                        <td class="text-center">{{ $contact->city }}</td>
                        <td class="text-center">{{ $contact->note ?? 'No note' }}</td>
                        <td class="text-center">{{ $contact->promotion_title ?? 'N/A' }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
