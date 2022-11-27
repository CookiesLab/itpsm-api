<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        p {
      text-align: center;
          width: 100%;
        }
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
          font-size: 12px;
        }
    </style>
</head>
<body>


<main>
  <div style="display: flex; flex-direction: row; justify-content: flex-start" >
    <img src="https://itpsm.edu.sv/wp-content/uploads/2019/01/logo-ITPSM-p.jpg" width="100px"/>
    <div style="display: flex; flex-direction: column;justify-content: center;align-items: center;align-content: center">
  <p>INSTITUTO TÉCNOLOGICO PADRE SEGUNDO MONTES<br>

    ADMINISTRACIÓN ACADÉMICA</p>
  <p><b>CERTIFICACIÓN GLOBAL DE NOTAS</b></p></div></div>
  <p>El infrascrito subdirector del Instituto Tecnológico Padre Segundo Montes CERTIFICA que
    <b>{{ $student['name'] . ' ' . $student['last_name'] }}</b> de esta institución de la carrera de Técnico superior en
    Hostelería y turismo, ha cursado los siguientes módulos obteniendo los resultados mostrados</p><br>
  <table>
    <tr>
      <th>CICLOS</th>
      <th>NUMERO DE ORDEN</th>
      <th>CODIGO ASIGNATURA</th>
      <th>ASIGNATURA</th>
      <th>UNIDADES VALORATIVAS</th>
      <th>NOTA</th>
      <th>RESULTADO</th>
      <th>CUM</th>
    </tr>

    <tbody>
    @foreach ($years as $index => $year)
      <tr>
        <td colspan="7"  style="background-color: #d9d9d9"><b>Año Academico {{ $year }}</b></td>
        @if($loop->first)
          <td rowspan={{$rows}}>{{$info->cum}}</td>
        @endif
      </tr>

      @foreach ($periods as $index => $period)
        @if($period->year == $year)}
        {{ $k=0 }}
        @foreach ($grades as $index2 => $grade)
          @if($period->year == $grade->period_year)}
          @if($period->code == $grade->period_code)}
          <tr>

              <td>Ciclo {{ $period->code }}  </td>



            <td > {{ $grade->curriculum_subject_order }}</td>
            <td > {{ $grade->curriculum_subject_code }}</td>
            <td > {{ $grade->curriculum_subject_label }}</td>
            <td > {{ $grade->uv }}</td>
            <td > {{ $grade->final_score }}</td>
            @if($grade->final_score>=6.0)}
            <td > APROBADA</td>
            @endif
            @if($grade->final_score<6.0)}
            <td style="color: red"> REPROBADA</td>
            @endif
          </tr>
          @endif
          @endif
          {{ $k++ }}
        @endforeach

        @endif
      @endforeach
    @endforeach
    </tbody>

  </table>
  <p>Y, para los usos que el interesado estime conveniente, se extiende la presente
    certificación, en la Comunidad Segundo Montes, el día {{now()->locale('es')->dayName}} {{now()->locale('es')->day}} de {{now()->locale('es')->monthName}} de {{now()->locale('es')->year}}.</p>
  <br><p>Ing. Víctor Eulises Rivera Chávez</p>
</main>


</body>
</html>
