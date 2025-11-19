<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="institution_id" class="block text-sm font-medium text-gray-700">Institution</label>
                            <select name="institution_id" id="institution_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Select Institution</option>
                                @foreach($institutions as $inst)
                                <option value="{{ $inst->id }}">{{ ucfirst($inst->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                            <input type="number" name="nis" id="nis" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Student Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo (JPG/PNG, Max 100KB)</label>
                            <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>