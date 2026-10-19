<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Records</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px 16px;
            background: #eef2f7;
            color: #172033;
        }

        main {
            max-width: 900px;
            margin: auto;
            padding: 28px;
            background: white;
            border-radius: 12px;
        }

        label { display: block; margin-top: 15px; }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #bbc5d3;
            border-radius: 6px;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px 22px;
            border: 0;
            border-radius: 6px;
            margin-top: 18px;
            cursor: pointer;
        }

        .success {
            padding: 12px;
            background: #dcfce7;
            border-radius: 6px;
        }

        .errors { color: #b91c1c; }
        .records { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<main>
    <h1>Student Record Application</h1>
    <p>Laravel application for our Jenkins CI/CD lab.</p>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('students.store') }}">
        @csrf

        <label for="name">Student name</label>
        <input id="name" name="name" value="{{ old('name') }}"
               maxlength="100" required>

        <label for="email">Email address</label>
        <input id="email" type="email" name="email"
               value="{{ old('email') }}" maxlength="255" required>

        <label for="course">Course</label>
        <input id="course" name="course" value="{{ old('course') }}"
               maxlength="100" required>

        <button type="submit">Save student</button>
    </form>

    <h2>Saved students</h2>

    <div class="records">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->course }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No students added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
