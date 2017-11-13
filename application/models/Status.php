<?php
/**
 * Classe de CRUD da tabela status
 *
 * @author  Paulo Jeffrerson <dark_4862@hotmail.com>
 * */
Class Status extends CI_Model{
    protected $table = 'status';

    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Seeciona dados da tabela status
     *
     * @param array|null $fields <opcional> Informe este campo para obeter colunas especificas do banco de dados no formato de vetor simples contendo os nomes dos campos. EX: $fields = array('id','name');
     * @param array|null $filters <opcional> Informe este campo para filtrar resultados. Ele requer um array associativo campo => valor. Caso queira modificar o operador de comparação use 'campo <operador>','valor a ser comparado'. EX: $filtes = array('id !=','2');
     * @return array Uma matriz contendo o resultado da query
     */
    public function select(array $fields = null,array $filters = null){
        if(!is_null($fields)):
            $this->db->select(implode(',',$fields));
        endif;

        if(!is_null($filters)):
            $this->db->where($filters);
        endif;

        return $this->db->get($this->table)->result();
    }
    /**
     * Insere dados na tabela status
     *
     * @param array $data Um vetor associativo campo/valor com os dados que devem ser inseridos
     * @return int A quantidade de linhas afetadas pelo insert
     */
    public function insert(array $data){
        $this->db->insert($this->table,$data);

        return $this->db->affected_rows();
    }
    /**
     * Atualiza um registro na tabela status
     *
     * @param array $data Um vetor associativo campo/valor contendo os dados a serem atualizados
     * @param array $filters Um vetor associativo campo/valor contendo os filtros do update
     * @return int A quantidade de linhas afetadas pelo update
     */
    public function update(array $data,array $filters){
        $this->db->update($this->table,$data,$filters);

        return $this->db->affected_rows();
    }
    /**
     * Deleta registros da tabela status
     * @param array $filters Vetor associativo campo/valor contendo os criterios desejados no delete
     * @return int A quantidade de linhas afetadas pelo delete
     */
    public function delete(array $filters){
        $this->db->delete($this->table,$filters);

        return $this->db->affected_rows();
    }

}