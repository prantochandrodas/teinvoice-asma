  <div class="row">
    <table class="table table-sm">
        <tr>
          <th >Status</th>
          <th>:</th>
          <td >
            <span class="bg-{{ $admin->status == 1 ? "success":"danger" }}">{{ $admin->status == 1 ? "Active":"Inactive" }}</span>
          </td>
        </tr>
        <tr>
          <th width="30%">Name</th>
          <th width="10%">:</th>
          <td width="60%">
            {{ $admin->name }}
          </td>
        </tr>
        <tr>
          <th>Email</th>
          <th>:</th>
          <td>
            {{ $admin->email }}
          </td>
        </tr>
        <tr>
          <th>Type</th>
          <th>:</th>
          <td>
            {{ ($admin->type == 1)? 'Admin' : 'General User' }}
          </td>
        </tr>
        <tr>
          <th>Photo</th>
          <th>:</th>
          <td>
            @if(!empty($admin->photo))
                <img src="{{ asset('uploads/admin/'.$admin->photo) }}" class="img-fluid img-thumbnail" style="height: 100px" alt="User">
            @endif
          </td>
        </tr>
    </table>
  </div>
