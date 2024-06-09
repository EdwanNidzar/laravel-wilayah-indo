<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">Edit Entry</h2>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $student->name }}">
      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <select class="form-control" id="gender" name="gender">
          <option value="">Select Gender</option>
          <option value="men" @if ($student->gender == 'men') selected @endif>Male</option>
          <option value="women" @if ($student->gender == 'women') selected @endif>Female</option>
        </select>
      </div>
      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $student->address }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="province">Provinsi</label>
          <select class="form-control" id="province" name="province_id">
            <option value="">Select Provinsi</option>
            @foreach ($provinces as $province)
              <option value="{{ $province->id }}" @if ($province->id == $student->province_id) selected @endif>
                {{ $province->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="city">Kota</label>
          <select class="form-control" id="city" name="city_id">
            <option value="">Select Kota</option>
            @foreach ($cities as $city)
              <option value="{{ $city->id }}" @if ($city->id == $student->regency_id) selected @endif>{{ $city->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="district">Kecamatan</label>
          <select class="form-control" id="district" name="district_id">
            <option value="">Select Kecamatan</option>
            @foreach ($districts as $district)
              <option value="{{ $district->id }}" @if ($district->id == $student->district_id) selected @endif>
                {{ $district->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="village">Kelurahan</label>
          <select class="form-control" id="village" name="village_id">
            <option value="">Select Kelurahan</option>
            @foreach ($villages as $village)
              <option value="{{ $village->id }}" @if ($village->id == $student->village_id) selected @endif>
                {{ $village->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#province').change(function() {
        var province_id = $(this).val();
        $('#city').empty().append('<option value="">Select Kota</option>');
        $('#district').empty().append('<option value="">Select Kecamatan</option>');
        $('#village').empty().append('<option value="">Select Kelurahan</option>');

        if (province_id) {
          $.ajax({
            url: '/students/cities/' + province_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $.each(data, function(key, city) {
                $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
              });
            }
          });
        }
      });

      $('#city').change(function() {
        var regency_id = $(this).val();
        $('#district').empty().append('<option value="">Select Kecamatan</option>');
        $('#village').empty().append('<option value="">Select Kelurahan</option>');

        if (regency_id) {
          $.ajax({
            url: '/students/districts/' + regency_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $.each(data, function(key, district) {
                $('#district').append('<option value="' + district.id + '">' + district.name +
                  '</option>');
              });
            }
          });
        }
      });

      $('#district').change(function() {
        var district_id = $(this).val();
        $('#village').empty().append('<option value="">Select Kelurahan</option>');

        if (district_id) {
          $.ajax({
            url: '/students/villages/' + district_id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $.each(data, function(key, village) {
                $('#village').append('<option value="' + village.id + '">' + village.name +
                  '</option>');
              });
            }
          });
        }
      });
    });
  </script>
</body>

</html>
