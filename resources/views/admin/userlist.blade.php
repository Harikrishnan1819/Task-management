<!DOCTYPE html>
<html lang="en">

@include('admin.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.nav')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th>S.No</th>
                    <th>Users</th>
                    <th>Task Tittle</th>
               </tr>

                @foreach ($users as $user)
                    <tr>
                        <td>
                            @if ($user->is_admin == 0)
                                {{ ++$i }}
                            @endif
                        </td>
                        <td>
                            @if ($user->is_admin == 0)
                                {{ $user->name }}
                            @endif
                        </td>
                        <td>
                            @foreach ($user->tasks as $task)
                                {{ $task->task }}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        @include('admin.footer')
</body>

</html>
