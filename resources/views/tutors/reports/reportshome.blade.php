<x-layout>
    <a href="{{ route('tutors.home', [$studentUserId]) }}">Voltar</a><br><br>


    <h1>Relatórios</h1>

    <a href="{{ route('tutors.frequencyreports.table', [$studentUserId]) }}">Frequência</a><br><br>
    <a href="{{ route('tutors.gradesreports.table', [$studentUserId]) }}">Média</a><br><br>
    <a href="{{ route('tutors.activitiesreport.table', [$studentUserId]) }}">Atividade Mais Jogadas</a><br><br>


</x-layout>