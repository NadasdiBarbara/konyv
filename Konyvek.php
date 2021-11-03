<?php

class Konyvek{
    private $id;
    private $iro;
    private $cim;
    private $oldalszam;
    private $mufaj;
    private $kiadasdatum;

    public function __construct(string $iro, string $cim, int $oldalszam, string $mufaj, DateTime $kiadasdatum){
        $this->iro = $iro;
        $this->cim = $cim;
        $this->oldalszam = $oldalszam;
        $this->mufaj = $mufaj;
        $this->kiadasdatum = $kiadasdatum;
    }

    public function uj(){
        global $db;

        $db->prepare('INSERT INTO adatok (iro, cim, oldalszam, mufaj, kiadasdatum) 
                    VALUES (:iro, :cim, :oldalszam, :mufaj, :kiadasdatum)')
            ->execute([
                ':iro' => $this->iro,
                ':cim' => $this->cim,
                ':oldalszam' => $this->oldalszam,
                ':mufaj' => $this->mufaj,
                ':kiadasdatum' => $this->kiadasdatum->format('Y-m-d'),
            ]);
    }

    public function getId() : ?int {
        return $this->id;
    } 

    public function getIro() : string {
        return $this->iro;
    }

    public function getCim() : string {
        return $this->cim;
    }

    public function getOldalszam() : int {
        return $this->oldalszam;
    }

    public function getMufaj() : string {
        return $this->mufaj;
    }

    public function getKiadasdatum() : DateTime {
        return $this->kiadasdatum;
    }

    public static function getById(int $id) : Konyvek{
        global $db;
        $t=$db->query("SELECT * FROM adatok WHERE id = $id")
            ->fetchAll();

        $konyv = new Konyvek($t[0]['iro'],$t[0]['cim'],$t[0]['oldalszam'],$t[0]['mufaj'],new DateTime($t[0]['kiadasdatum']));
        return $konyv;
    
    }
    
  public function setIro(string $iro){
        $this->iro = $iro;
    }
    
    public function setCim(string $cim) {
       $this->cim = $cim;
   }

   public function setOldalszam(int $oldalszam) {
        $this->oldalszam = $oldalszam;
    }

    public function setMufaj(string $mufaj){
        $this->mufaj = $mufaj;
    }

    public function setKiadasdatum(DateTime $kiadasdatum) {
        $this->kiadasdatum = $kiadasdatum;
    }

    public function mentes(string $id){
        global $db;

        $db->prepare('UPDATE adatok 
                        SET iro=:iro, cim=:cim, oldalszam=:oldalszam, mufaj=:mufaj, kiadasdatum=:kiadasdatum WHERE id=:id')
            ->execute([
                ':iro' => $this->iro,
                ':cim' => $this->cim,
                ':oldalszam' => $this->oldalszam,
                ':mufaj' => $this->mufaj,
                ':kiadasdatum' => $this->kiadasdatum->format('Y-m-d'),
                ':id'=> $id,
            ]);
    }
    public static function torol(int $id) {
        global $db;

        $db->prepare('DELETE FROM adatok WHERE id = :id')
            ->execute([':id'=>$id]);
    }

    public static function osszes():array{
        global $db;
        $t=$db->query("SELECT * FROM adatok ORDER BY id ASC")
                ->fetchAll();
        $eredmeny = [];

        foreach ($t as $konyv) {
            $obj = new Konyvek($konyv['iro'],$konyv['cim'],$konyv['oldalszam'],$konyv['mufaj'],new DateTime($konyv['kiadasdatum']));
            $obj->id = $konyv['id'];
            $eredmeny[] = $obj;
        }
        return $eredmeny;
    }
    



}
?>
