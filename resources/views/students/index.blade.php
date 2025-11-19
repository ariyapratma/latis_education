<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('students.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Add Student</a>

                    <div class="mb-4">
                        <label for="filterInstitution" class="block text-sm font-medium text-gray-700">Filter Institution:</label>
                        <select id="filterInstitution" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Institutions</option>
                            @foreach($institutions as $institution)
                            <option value="{{ $institution->id }}">{{ ucfirst($institution->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table id="studentTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institution</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Data akan dimuat oleh DataTables -->
                        </tbody>
                    </table>

                    <button id="exportExcelBtn" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Export to Excel</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#studentTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('students.data') }}",
                    data: function(d) {
                        d.institution = $('#filterInstitution').val();
                    }
                },
                columns: [{
                        data: 'institution',
                        name: 'institution.name'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        render: function(data, type, row) {
                            return data ? '<img src="' + data + '" width="50" height="50" alt="Student Photo">' : 'No Photo';
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Event listener for filter institution
            $('#filterInstitution').on('change', function() {
                table.ajax.reload(); // Reload DataTables
            });

            // Event listener for export Excel
            $('#exportExcelBtn').on('click', function() {
                var selectedInstitution = $('#filterInstitution').val();
                // Redirect to route export, with institution filter if available
                window.location.href = '{{ route("students.export") }}' + (selectedInstitution ? '?institution=' + selectedInstitution : '');
            });
        });
    </script>
</x-app-layout>