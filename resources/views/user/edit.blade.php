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

            <!-- End of Main Content -->
          <div class="container">

            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{route('task.index')}}">Back</a>
                    </div>
                </div>
            </div>
            <br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('task.update', $task->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Task_tittle:</strong>
                            <input type="text" name="task" class="form-control" value="{{ $task->task }}" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Task_Description:</strong>
                            <input type="text" name="task_descripton" class="form-control" value="{{ $task->task_descripton }}" required >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Steps:</strong>
                            <textarea class="form-control"  style="height:150px" name="step_descripton" required >{{ implode(', ', $task->steps->pluck('step_descripton')->toArray()) }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                </div>
            </form>
          </div>
          </div>
            <!-- Footer -->
           @include('user.footer')
</body>

</html>
