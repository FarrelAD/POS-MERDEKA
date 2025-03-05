<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Username</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">ID Level Pengguna</th>
                    <th class="border border-gray-300 px-4 py-2">Kode level</th>
                    <th class="border border-gray-300 px-4 py-2">Nama level</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $d->user_id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $d->username }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $d->nama }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $d->level_id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $d->level->level_kode }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $d->level->level_name }}</td>
                        <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                            <a 
                                href="/user/ubah/{{ $d->user_id }}" 
                                class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                Ubah
                            </a>
                            <a 
                                href="/user/hapus/{{ $d->user_id }}"
                                class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">
                                Hapus
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>