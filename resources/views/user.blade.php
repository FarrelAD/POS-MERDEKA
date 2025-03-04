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
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $data->user_id }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $data->username }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $data->nama }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $data->level_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>