
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <section class="sidebar">
    <!-- sidebar menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li>
        <a href="{{ URL::route('user.dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

         <li class="treeview">
        <a href="#">
          <i class="fa icon-student"></i>
          <span>Clients</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{route('clients.create')}}">
              <i class="fa fa-user-md"></i> <span>Add</span>
            </a>
          </li>
          <li>
            <a href="{{route('administrator.user_password_reset')}}">
              <i class="fa fa-eye-slash"></i> <span>Reset User Password</span>
            </a>
          </li>
          <li>
            <a href="{{URL::route('user.role_index')}}">
              <i class="fa fa-users"></i> <span>Role</span>
            </a>
          </li>


        </ul>
      </li>
   

      @role('Admin')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>Administrator</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{URL::route('administrator.user_index')}}">
              <i class="fa fa-user-md"></i> <span>System Admin</span>
            </a>
          </li>
          <li>
            <a href="{{route('administrator.user_password_reset')}}">
              <i class="fa fa-eye-slash"></i> <span>Reset User Password</span>
            </a>
          </li>
          <li>
            <a href="{{URL::route('user.role_index')}}">
              <i class="fa fa-users"></i> <span>Role</span>
            </a>
          </li>


        </ul>
      </li>
      @endrole
      @can('user.index')
        <li>
          <a href="{{ URL::route('user.index') }}">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
      @endcan

      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-pdf-o"></i>
          <span>Reports</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          {{-- @can('report.student_idcard')
          <li>
            <a href="#">
              <i class="fa fa-id-card"></i> <span>Student Idcard Print</span>
            </a>
          </li>
          @endcan
            @can('report.employee_idcard')
          <li>
            <a href="#">
              <i class="fa fa-id-card"></i> <span>Employee Idcard Print</span>
            </a>
          </li>
              @endcan --}}
        </ul>
      </li>

      @role('Admin')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>Settings</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ URL::route('settings.institute') }}">
              <i class="fa fa-building"></i> <span>Institute</span>
            </a>
          </li>         
        </ul>
      </li>
      @endrole
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
