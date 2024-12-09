<div class="row">
    <table class="table table-sm">
        @if(!empty($branch->photo))
        <tr>
            <td colspan="2" class="text-center">
                <img src="{{ asset('uploads/branch/'.$branch->photo) }}" class="img-fluid img-thumbnail" style="height: 100px" alt="branch User">
            </td>
        </tr>
        @endif
        <tr>
          <th >Status</th>
          <td >
            <span class="bg-{{ $branch->status == 1 ? "success":"danger" }}">{{ $branch->status == 1 ? "Active":"Inactive" }}</span>
          </td>
        </tr>
        <tr>
          <th width="30%">Name</th>
          <td width="70%">
            {{ $branch->name }}
          </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>
              {{ $branch->email }}
            </td>
        </tr>
        <tr>
          <th>Address</th>
          <td>
            {{ $branch->address }}
          </td>
        </tr>
        <tr>
          <th>Country </th>
          <td>
            {{ $branch->country->name }}
          </td>
        </tr>
        <tr>
          <th>Division</th>
          <td>
            {{ $branch->division->name }}
          </td>
        </tr>
        <tr>
          <th>Area</th>
          <td>
            {{ $branch->area->name ?? "" }}
          </td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>
            {{ $branch->phone }}
          </td>
        </tr>

    </table>
  </div>
