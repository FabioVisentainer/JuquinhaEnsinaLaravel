<x-layout>
    <a href="{{ route('coordinators.home') }}">Voltar</a><br><br>


    <h1>Relatórios</h1>

    <a href="{{ route('coordinators.frequencyreports.table') }}">Frequência</a><br><br>
    <a href="{{ route('coordinators.gradesreports.table') }}">Média</a><br><br>
    <a href="{{ route('coordinators.activitiesreport.table') }}">Atividade Mais Jogadas</a><br><br>
    <a href="{{ route('coordinators.sstudentsreport.table') }}">Alunos com Portabilidade</a><br><br>


</x-layout>