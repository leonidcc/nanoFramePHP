<?php

// php gen/crud.php test name:string price:float valor:int
include 'core/conexion.class.php';
include 'config.php';

$ENTIDAD = strtolower($argv[1]); array_shift($argv); array_shift($argv);
$ATRIBUTOS = $argv;

//Create Table
// ==============================================
  $str = 'CREATE TABLE IF NOT EXISTS `'.$ENTIDAD.'` (
    `id` int(11) NOT NULL AUTO_INCREMENT,';
  $k=0;
  for (; $k < count($ATRIBUTOS) ; $k++) {
    $i = explode(':',$ATRIBUTOS[$k]);
    $str.='   `'.$i[0].'` '.getTyp($i[1]).' NOT NULL,
    ';
  }
  $str.='PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

  $db->consult($str,[]);

  function getTyp($t){
    switch ($t) {
      case 'string':
        return 'varchar(30)';
        break;
      case 'text':
        return 'varchar(200)';
        break;
      case 'int':
        return 'int(11)';
        break;
      case 'date':
        return 'datetime';
        break;
      case 'float':
        return 'float(10,3)';
        break;
      default:
        echo "Error Type Sintax string-int-float-date-text";
        die();
        break;
    }
  }
// Create Model
// ==============================================
$archivo = fopen("modelos/$ENTIDAD.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}

fwrite($archivo, '<?php

class Model_'.ucfirst($ENTIDAD).'{
    private $db;
    function __construct($ddbb){
        $this->db = $ddbb;
    }
    public function get($id){
        $qry = "SELECT * FROM `'.$ENTIDAD.'`   WHERE id = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function getsByUser($id){
        $qry = "SELECT * FROM `'.$ENTIDAD.'`  WHERE id_user = ? ";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }
    public function gets(){
        $qry = "SELECT * FROM `'.$ENTIDAD.'` ";
        $data  = $this->db->consult($qry, []);
        return $data;
    }

    public function create('.sqlCreateArg($ATRIBUTOS).'){
        $qry = "INSERT INTO `'.$ENTIDAD.'` '.sqlCreate($ATRIBUTOS).'";
        $data  = $this->db->consult($qry, ['.sqlCreateArg($ATRIBUTOS).']);
        return $data;
    }
    public function update('.sqlCreateArg($ATRIBUTOS).', $id){
        $qry = "UPDATE `'.$ENTIDAD.'` SET  '.sqlCreateUpdate($ATRIBUTOS).'  WHERE id = ?";
        $data  = $this->db->consult($qry, ['.sqlCreateArg($ATRIBUTOS).', $id]);
        return $data;
    }
    public function delete($id){
        $qry = "DELETE FROM `'.$ENTIDAD.'` WHERE id = ?";
        $data  = $this->db->consult($qry, [$id]);
        return $data;
    }

}

?>');
fflush($archivo);fclose($archivo);

function sqlCreate($atr){
  $str = '(';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);  $str.='`'.$i[0].'`,';
  }
  $i = explode(':',$atr[$k]);
  $str.='`'.$i[0].'`)
                VALUES (';
  $k = 0;
  for (; $k < count($atr) - 1  ; $k++) {
     $str.='?,';
  }
  $str.='?)';
  return $str;
}

function sqlCreateArg($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='$'.$i[0].', ';
  }
  $i = explode(':',$atr[$k]);
  $str.='$'.$i[0];
  return $str;
}

function sqlCreateUpdate($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='`'.$i[0].'` = ?, ';
  }
  $i = explode(':',$atr[$k]);
  $str.='`'.$i[0].'` = ? ';
  return $str;
}

// Create ENTIDAD CREATE
// ==============================================
$micarpeta = DIR_ROUTES."/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen(DIR_ROUTES."/panel/$ENTIDAD/create.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class Create  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "'.ucfirst($ENTIDAD).'";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $html .= $this->create("panel/'.$ENTIDAD.'/create");

         // $html .= $this->create("panel/'.$ENTIDAD.'/create",[
         //   "categorias" => $this->model("categoria")->gets()
         // ]);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function add($value=""){
       $this->model("'.$ENTIDAD.'")->create(
           '.createArgAdd($ATRIBUTOS).'
        );
       header("location:/panel/'.$ENTIDAD.'");
     }
}
?>');
fflush($archivo);fclose($archivo);

function createArgAdd($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr) - 1 ; $k++) {
    $i = explode(':',$atr[$k]);
    if($i[0] == "id_user") $str.='$this->sessionUser()->id,
           ';
    else $str.='$_POST["'.$i[0].'"],
           ';
  }
  $i = explode(':',$atr[$k]);
  if($i[0] == "id_user") $str.='$this->sessionUser()->id';
  else $str.='$_POST["'.$i[0].'"]';
  return $str;
}

// Create VISTA CREATE
// ==============================================
$micarpeta = "vistas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/panel/$ENTIDAD/create.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section>
    <div class="container">
      <div class="py-3 d-flex justify-content-between align-items-end">
        <div class="">
          <h4>Añadir '.ucfirst($ENTIDAD).'</h4>
          <a href="/panel">Panel </a> /
          <a href="/panel/'.$ENTIDAD.'">'.ucfirst($ENTIDAD).' </a> /
           new
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container py-3">
      <form class="" action="/panel/'.$ENTIDAD.'/create/add" method="post">
        <div class="row pb-3 ">
          '.createInputs($ATRIBUTOS).'
        </div>
        <button type="submit" class="btn my-3 btn-primary">Agregar</button>
      </form>
    </div>
  </section>


</kaiwik>

<style>
    .gereado{

    }
</style>
');
fflush($archivo);fclose($archivo);
function createInputs($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);

    if(explode('_',$i)[0]=="id"){
      $str.='<div class="col-md-12 ">
        <div class="form-floating  ">
          <select   name="'.$i[0].'"  required class="form-select shadow-sm"  >
            <?php foreach ($'.explode('_',$i)[1].' as $key => $value): ?>
                <option value="<?= $value->id ?>"><?= $value->name ?></option>
           <?php endforeach; ?>
         </select>
          <label for="floatingSelect">Seleccione una '.explode('_',$i)[1].'</label>
        </div>
      </div>';
    }
    else $str.='<div class=" col-md-12">
      <div class="form-floating pb-2">
         <input
          class="shadow-sm form-control"
          name="'.$i[0].'"   required  placeholder="'.$i[0].'"
          >
         <label >'.$i[0].' </label>
       </div>
    </div>';
  }
  return $str;
}

// Create VISTA READ
$micarpeta = "vistas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/panel/$ENTIDAD/read.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>

    let $list'.$ENTIDAD.' = document.getElementById("list'.$ENTIDAD.'");
    let $filtro'.$ENTIDAD.' = document.getElementById("filtro'.$ENTIDAD.'");
    $filtro'.$ENTIDAD.'.addEventListener("keyup",(e)=>{
      $list'.$ENTIDAD.'.querySelectorAll(".list").forEach((item, i) => {
        if(item.innerHTML.includes(e.target.value)) item.classList.remove("d-none");
        else  item.classList.add("d-none");
      });
     })

</script>

<kaiwik>

<section>
  <div class="container">
    <div class="py-3 d-flex justify-content-between align-items-end">
      <div class="">
        <h4>Listando '.ucfirst($ENTIDAD).'</h4>
        <a href="/panel">Panel </a> /
        '.$ENTIDAD.'
      </div>
      <div class="">
        <a href="/panel/item/create" class="btn btn-primary btn-sm ">Nuevo '.$ENTIDAD.'</a>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row pb-3 ">
      <div class=" col-md-8">
        <div class="form-floating pb-2">
           <input id="filtro'.$ENTIDAD.'" type="email" placeholder="EtiquetasNúmeroNombre" class="shadow-sm form-control" id="floatingInputValue" placeholder="name@example.com"  >
           <label for="floatingInputValue">Escribe tu busqueda </label>
         </div>
      </div>
      <div class="col-md-4 ">
        <div class="form-floating  ">
          <select class="form-select shadow-sm"   aria-label="Floating label select example">
            <option value="1">One</option>
            <option value="2">Two</option>
          </select>
          <label for="floatingSelect">Seleccione una categoría</label>
        </div>
      </div>
    </div>
  </div>
</section>

  <section>
    <div class="container">
      <div class="row">
        <div class="content   mb-5" id="listItem">
        <?php foreach ($data as $key => $value): ?>
          <div class="list bg-white py-2 my-2 shadow-sm">
            <div class="item">
            <div>
              <strong><?= $value->id ?></strong>
            </div>
            </div>
            <div class="item">
              <div>
                <a href="/panel/'.$ENTIDAD.'/delete/<?= $value->id?>" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                <a href="/panel/'.$ENTIDAD.'/update/<?= $value->id?>" class="btn btn-primary btn-sm"><i class="bi bi-pen"></i></a>
                <a href="/'.$ENTIDAD.'/<?= $value->id?>" class="btn btn-secondary btn-sm">Detalles</a>
              </div>
            </div>

            <div class="item">
              <div>
               <small class="text-primary">OPTION</small>
               <div>
                 <a href="/panel/'.$ENTIDAD.'/something">
                  <div class="disabled">
                      <div class="switch active "></div>
                  </div>
                </a>
               </div>
              </div>
            </div>
            '.createTableList($ATRIBUTOS).'
        </div>
        <?php endforeach; ?>
      </div>
      </div>
    </div>

  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function createTableList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<div class="item">
      <div >
        <small class="text-primary text-uppercase">'.$i[0].'</small>
        <div> <?= $value->'.$i[0].' ?></div>
      </div>
    </div>
                 ';
  }
  return $str;
}



// Create CONTROLLER READ
$micarpeta = DIR_ROUTES."/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen(DIR_ROUTES."/panel/$ENTIDAD/index.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class '.ucfirst($ENTIDAD).'  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "'.ucfirst($ENTIDAD).'";
     }
     public function index(){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model("'.$ENTIDAD.'")->gets();

         $html .= $this->create("panel/'.$ENTIDAD.'/read", $data);

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

     public function delete($args=[]){
       $id = $args[0];
       $this->model("'.$ENTIDAD.'")->delete($id );
       header("location:/panel/'.$ENTIDAD.'");
    }
}

?>
');
fflush($archivo);fclose($archivo);



// Create VISTA UPDATE
$micarpeta = "vistas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/panel/$ENTIDAD/update.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

<section>
  <div class="container">
    <div class="py-3 d-flex justify-content-between align-items-end">
      <div class="">
        <h4>Actualizar  '.ucfirst($ENTIDAD).'</h4>
        <a href="/panel">Panel </a> /
        <a href="/panel/'.$ENTIDAD.'">'.ucfirst($ENTIDAD).' </a> /
         update / <?= $data->id ?>
      </div>
      <div class="">
        <a href="/panel/'.ucfirst($ENTIDAD).'/create" class="btn btn-primary btn-sm ">Nuevo '.ucfirst($ENTIDAD).'</a>
      </div>
    </div>
  </div>
</section>

  <section>
      <div class="container py-5 ">
             <form class="" action="/panel/'.$ENTIDAD.'/update/put" method="post">
                <input name="id" value="<?= $data->id ?>" required   hidden />
                  '.createInputsUpdate($ATRIBUTOS).'
                 <button type="submit" class="btn   my-3 btn-primary btn-sm">Actualizar</button>
             </form>
      </div>
  </section>

  <section>
    <div class="container py-3">
      <form class="" action="/panel/'.$ENTIDAD.'/update/put" method="post">
        <div class="row pb-3 ">
          <input name="id" value="<?= $data->id ?>" required   hidden />
            '.createInputsUpdate($ATRIBUTOS).'
        </div>
        <button type="submit" class="btn my-3 btn-primary">Actualizar</button>
      </form>
    </div>
  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>


');
fflush($archivo);fclose($archivo);
function createInputsUpdate($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);

    if(explode('_',$i)[0]=="id"){

      $str.='  <div class="col-md-12 ">
          <div class="form-floating  ">
            <select  name="'.$i[0].'"  required class="form-select shadow-sm" aria-label="Default select example">
              <?php foreach ($'.explode('_',$i)[1].' as $key => $value): ?>
                <?php if ($value->id == $data->'.$i[0].'): ?>
                  <option selected value="<?= $value->id ?>"><?= $value->name ?></option>
                <?php else: ?>
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                <?php endif; ?>
             <?php endforeach; ?>
           </select>
            <label for="floatingSelect">Seleccione una '.explode('_',$i)[1].'</label>
          </div>
        </div>';
    }
    else $str.='<div class=" col-md-12">
                <div class="form-floating pb-2">
                   <input
                    class="shadow-sm form-control"
                    name="'.$i[0].'" value="<?= $data->'.$i[0].' ?>" required  placeholder="'.$i[0].'"
                    >
                   <label >'.$i[0].' </label>
                 </div>
              </div>';
  }
  return $str;
}
// Create VISTA INDEX PUBLIC
$micarpeta = "vistas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/panel/$ENTIDAD/index.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>

  <section>
    <div class="container">
      <div class="py-3 d-flex justify-content-between align-items-end">
        <div class="">
          <h4>'.ucfirst($ENTIDAD).'</h4>
          <a href="/">Home </a> /
           '.ucfirst($ENTIDAD).'
        </div>
        <div class="">
          <a href="/panel/item/create" class="btn btn-primary btn-sm ">Nuevo Item</a>
        </div>
      </div>
    </div>
  </section>


  <section >
      <div class="container py-3">

          <div class="row">
              <?php foreach ($data as $key => $value): ?>
                <div class="col-md-4 ">
                  <div class="card p-3 m-2">
                      <p class="text-muted"><?= $value->id?></p>
                        '.valueIndexList($ATRIBUTOS).'
                      <a href="/'.$ENTIDAD.'/<?= $value->id?>">Detalles</a>
                    </div>
                  </div>
              <?php endforeach; ?>
          </div>


      </div>
  </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function valueIndexList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<p><?= $value->'.$i[0].' ?></p>
                 ';
  }
  return $str;
}

// Create VISTA READ
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen(DIR_ROUTES."/panel/$ENTIDAD/update.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class Update  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = '.$ENTIDAD.';
     }
     public function index($args = []){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         $data = $this->model('.$ENTIDAD.')->get($args[0]);
         $html .= $this->create("panel/'.$ENTIDAD.'/update", $data[0]);

         // $html .= $this->create("panel/'.$ENTIDAD.'/update",[
         //   "data" => $data[0],
         //   "categorias" => $this->model("categoria")->gets()
         //   ]
         // );

         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }
     public function put($arg = []){
       $this->model("'.$ENTIDAD.'")->update(
         '.createArgAdd($ATRIBUTOS).',
          $_POST["id"]
        );
         header("location:/panel/'.$ENTIDAD.'");
    }
}

?>

');
fflush($archivo);fclose($archivo);


// Create VISTA ENTIDAD
$micarpeta = "vistas/panel/$ENTIDAD";
if (!file_exists($micarpeta)) {
    mkdir($micarpeta, 0777, true);
}
$archivo = fopen(DIR_ROUTES."/$ENTIDAD.php","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<?php
 class '.ucfirst($ENTIDAD).'  extends Context {
     function __construct( ){
         parent::__construct();
         $this->title = "'.$ENTIDAD.'";
     }
     public function index($arg = []){
         $html  = ($this->sessionExist())
            ?$this->create("cmp/navLog")
            :$this->create("cmp/nav");

         if(count($arg)){
           $data = $this->model("'.$ENTIDAD.'")->get($arg[0])[0];
           $html .= $this->create("panel/'.$ENTIDAD.'/show",$data);
         }else {
           $data = $this->model("'.$ENTIDAD.'")->gets();
           $html .= $this->create("panel/'.$ENTIDAD.'/index", $data);
         }
         $html  .= $this->create("cmp/footer");
         return $this->ret($html);
     }

}

?>
');
fflush($archivo);fclose($archivo);

// Create VISTA SHOW
$micarpeta = "vistas/$ENTIDAD";
if (!file_exists($micarpeta)) {
  mkdir($micarpeta, 0777, true);
}
$archivo = fopen("vistas/$ENTIDAD/show.kaiwik","w+b");
if($archivo == false ){
  echo "Error al crear el archivo";
  die();
}
fwrite($archivo,'<script>
    console.log("HOLA");
</script>

<kaiwik>
 
  <section>
    <div class="container">
      <div class="py-3 d-flex justify-content-between align-items-end">
        <div class="">
          <h4> Detalles </h4>
          <a href="/">Home</a> /
          <a href="/'.$ENTIDAD.'"> '.ucfirst($ENTIDAD).'</a> /
          <?= $data->id?>
        </div>
      </div>
    </div>
  </section>

  <section>
      <div class="container py-5 ">
      '.valueShowList($ATRIBUTOS).'
      </div>
   </section>

</kaiwik>

<style>
    .colo{
        color: blue;
    }
    .colo2{
        color: green;
    }
</style>
');
fflush($archivo);fclose($archivo);
function valueShowList($atr){
  $str = '';
  $k=0;
  for (; $k < count($atr)  ; $k++) {
    $i = explode(':',$atr[$k]);
    $str.='<strong>'.$i[0].'</strong><p><?= $data->'.$i[0].' ?></p>
    ';
  }
  return $str;
}

echo "Success";
?>
