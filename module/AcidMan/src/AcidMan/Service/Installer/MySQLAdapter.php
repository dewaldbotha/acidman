<?php
namespace AcidMan\Service\Installer;

class MySQLAdapter
{
    protected $db = NULL;
    
    public function __construct($db)
    {
        $this->setDbAdapter($db);
    }
    
    public function setDbAdapter($db)
    {
        $this->db = $db;
        return $this;
    }
    
    public function getAdapter()
    {
        return $this->db;
    }
    
    
}