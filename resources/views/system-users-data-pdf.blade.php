<html>
<head>
  <style>
    @page {
      margin-left: 10px;
      margin-right: 25px;
      margin-bottom: 20px;
    }
    body {
      margin-left: 10px;
      margin-right: 25px;
      margin-bottom: 20px;
    }

    table {
      border-collapse: collapse;
      font-size: 10px;
    }
    .hf-table {
      /*font-size: 12px !important;*/
      border:0 !important;
    }
    .hf-table td {
      border:0 !important;
    }
    .page-break-avoid {
      page-break-inside:avoid;
      break-inside: avoid;
      -webkit-column-break-inside: avoid;
    }
    .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-top: 0 !important;
    border-left: 0 !important;
    border-right: 0 !important;
    }
    .table th,
    .table td {
    padding: 0.25rem;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
    }
    .table thead th {
    vertical-align: middle;
    border-bottom: 2px solid #e9ecef;
    padding: 0.10rem;
    }
    .table tbody + tbody {
    border-top: 2px solid #e9ecef;
    }
    .table .table {
    background-color: #fff;
    }
    .table-sm th,
    .table-sm td {
    padding: 0.3rem;
    }
    .table-bordered {
    border: 1px solid #e9ecef;
    }
    .table-bordered th,
    .table-bordered td {
    border: 1px solid #e9ecef;
    }
    .table-bordered thead th,
    .table-bordered thead td {
    border-bottom-width: 2px;
    }
    .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
    }

    .table-primary,
    .table-primary > th,
    .table-primary > td {
    background-color: #b8daff;
    }
    .table-secondary,
    .table-secondary > th,
    .table-secondary > td {
    background-color: #dddfe2;
    }
    .table-success,
    .table-success > th,
    .table-success > td {
    background-color: #c3e6cb;
    }

    .table-info,
    .table-info > th,
    .table-info > td {
    background-color: #bee5eb;
    }

    .table-warning,
    .table-warning > th,
    .table-warning > td {
    background-color: #ffeeba;
    }

    .table-danger,
    .table-danger > th,
    .table-danger > td {
    background-color: #f5c6cb;
    }

    .table-light,
    .table-light > th,
    .table-light > td {
    background-color: #fdfdfe;
    }

    .table-dark,
    .table-dark > th,
    .table-dark > td {
    background-color: #c6c8ca;
    }

    .table-active,
    .table-active > th,
    .table-active > td {
    background-color: rgba(0, 0, 0, 0.075);
    }

    .table .thead-dark th {
    color: #fff;
    background-color: #212529;
    border-color: #32383e;
    }
    .table .thead-light th {
    color: #495057;
    background-color: #e9ecef;
    border-color: #e9ecef;
    }
    .table-dark {
    color: #fff;
    background-color: #212529;
    }
    .table-dark th,
    .table-dark td,
    .table-dark thead th {
    border-color: #32383e;
    }
    .table-dark.table-bordered {
    border: 0;
    }
    .table-dark.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.05);
    }
    .page-break {
      page-break-after: always;
    }
  </style>
</head>
  <body>
    <header>
        <h1>ITPSM</h1>
    </header>

    <main>
      <table  class="table table-bordered table-striped" align="center" style="width:100%;text-align:center;">
        <thead>
		      <th scope="col">Carnet</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Correo</th>
		      <th scope="col">Contraseña</th>
        </thead>
        <tbody>
          @foreach ($users as $index => $user)
            <tr>
              <td>{{ $user->carnet }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->password }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </main>

    <footer>
        <h1>ITPSM</h1>
    </footer>
  </body>
</html>
