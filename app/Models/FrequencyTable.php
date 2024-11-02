<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequencyTable extends Model
{
    use HasFactory;

    //setando o nome da tabela a ser buscada
    protected $table = 'tb_frequency_table';

    // Specificar a Primary Key
    protected $primaryKey = 'frequency_table_id';

    // Disable timestamps if you don't want Laravel to manage created_at and updated_at
    public $timestamps = true; // or false if you want to manage timestamps manually

    // adicionar caso uso o método 2 de adição na base de dados no controlador
    // incluir os nomes das colunas que serão inseridas
    protected $fillable = ['entity_id', 'class_id', 'frequency_date'];

    protected $timestamp = true; //setar para falso caso não use created_at and updated_at

}





