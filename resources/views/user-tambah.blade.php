<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengguna</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-4">
        <form class="mt-4" method="post" action="{{ route('user-tambah-simpan') }}">

            {{ csrf_field() }}
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input 
                    type="text" 
                    id="username"
                    name="username"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter your username">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input 
                    type="text" 
                    id="name"
                    name="nama"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter your name">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter your password">
            </div>

            <div class="mb-4">
                <label for="level_id" class="block text-sm font-medium text-gray-700">Level ID</label>
                <input 
                    type="number" 
                    id="level_id"
                    name="level_id"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="Enter level ID">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Submit</button>
        </form>
    </div>
</body>

</html>