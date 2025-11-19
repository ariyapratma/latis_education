<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="institution_id" class="block text-sm font-medium text-gray-700">Institution</label>
                            <select name="institution_id" id="institution_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Select Institution</option>
                                @foreach($institutions as $inst)
                                <option value="{{ $inst->id }}" {{ $inst->id == $student->institution_id ? 'selected' : '' }}>{{ ucfirst($inst->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                            <input type="number" name="nis" id="nis" value="{{ old('nis', $student->nis) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Student Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">New Photo (JPG/PNG, Max 100KB)</label>
                            <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @if($student->photo)
                            <p class="mt-1 text-sm text-gray-500">Current Photo: <img src="{{ asset('storage/' . $student->photo) }}" width="50" height="50" alt="Student Photo"></p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>