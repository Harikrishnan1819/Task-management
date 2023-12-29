<!DOCTYPE html>
<html lang="en">

@include('user.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('user.nav')
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-info" href="{{ route('task.create') }}"> Create New Task</a>
                    </div>
                </div>
            </div>
            <br>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table class="table table-bordered">
                <tr>
                    <th>S.No</th>
                    <th>Tittle</th>
                    <th>Tittle description</th>
                    <th>Due date</th>
                    <th>Steps</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->task }}</td>
                        <td>{{ $task->task_descripton }}</td>
                        <td>{{ date('d-m-Y', strtotime($task->due_date)) }}</td>
                        <td>
                            <form action="{{ route('update.status') }}" method="post">
                                <ul>
                                    @foreach ($task->steps as $step)
                                        @csrf
                                        <li>
                                            <input type="checkbox" name="step_ids[]" value="{{ $step->id }}"
                                                @if ($step->status) disabled @endif>
                                            {{ $step->step_descripton }}
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Update Status</button>
                            </form>
                        </td>
                        <td style="text-align: center">
                            @foreach ($task->steps as $step)
                                @if ($step->status == false)
                                    <ul>
                                        <li class="btn btn-sm btn-warning mt-2"> Pending</li>
                                    </ul>
                                @else
                                    <ul>
                                        <li class="btn btn-sm btn-success mt-2"> Finished</li>
                                    </ul>
                                @endif
                            @endforeach
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a class="btn btn-outline-primary btn-sm" role="button"
                                href="{{ route('task.edit', $task->id) }}">Edit</a>
                            <form style="display: inline-block" action="{{ route('task.destroy', $task->id) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {!! $tasks->links() !!}
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        @include('user.footer')
</body>

</html>
