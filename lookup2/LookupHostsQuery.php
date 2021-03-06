<?PHP
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

// FIXME - fl, is this needed?
//require_once(REL(__FILE__, "../shared/global_constants.php"));
require_once(REL(__FILE__, "../classes/Query.php"));
require_once(REL(__FILE__,'LookupHosts.php'));

class lookupHostQuery extends Query {

  function execSelect() {
    $sql = "select * from `lookup_hosts` WHERE `active`='y' ORDER BY seq";
    return $this->_query($sql, "Error accessing the host table.");
  }
  function execSelectAll() {
    $sql = "select * from `lookup_hosts` ORDER BY active,seq";
    return $this->_query($sql, "Error accessing the host table.");
  }
  function execSelectOne($host_id) {
    $sql = "select * from `lookup_hosts` WHERE id=" . (0 + $host_id);
    return $this->_query($sql, "Error accessing the host table.");
  }

  function fetchRow() {
    global $postVars;
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }
    //echo "from fetch:<br />";print_r($array);echo "<br />";
    $set = new LookupHosts();
    $set->setId($array["id"]);
    $set->setactive($array["active"]);
    $set->setSeq($array["seq"]);
    $set->setHost($array["host"]);
    $set->setName($array["name"]);
    $set->setDb($array["db"]);
    $set->setUser($array["user"]);
    $set->setPw($array["pw"]);
    $set->setCharset($array["charset"]);

    return $set;
  }

  function insert($set) {
    $sql = $this->mkSQL("insert into lookup_hosts set "
                        . "seq=%Q, active=%Q,"
                        . "host=%Q, name=%Q, db=%Q, "
                        . "user=%Q, pw=%Q, charset=%Q ",
                        $set->getSeq(), $set->getActive() == "y"?"y":"n",
                        $set->getHost(), $set->getName(), $set->getDb(),
                        $set->getUser(), $set->getPw(), $set->getCharset()
                        );
      //echo "sql=$sql <br />";
    return $this->_query($sql, "Error inserting host information");
  }

  function update($set) {
    $sql = $this->mkSQL("update lookup_hosts set "
                        . "seq=%Q, active=%Q,"
                        . "host=%Q, name=%Q, db=%Q, "
                        . "user=%Q, pw=%Q, charset=%Q "
                        . "where id=%N ",
                        $set->getSeq(), $set->getActive()?"y":"n",
                        $set->getHost(), $set->getName(), $set->getDb(),
                        $set->getUser(), $set->getPw(), $set->getCharset(), $set->getId()
                        );
      //echo "sql=$sql <br />";
    return $this->_query($sql, "Error updating host information");
  }

  function delete($set) {
    $sql = $this->mkSQL("delete from lookup_hosts  "
                        . "where id=%N ",
                        $set->getId()
                        );
      //echo "sql=$sql <br />";
    return $this->_query($sql, "Error deleting host information");
  }
}

function deleteHost ($array) {
  $set = new LookupHosts();
  $set->setId($array["id"]);

  $hostQ = new LookupHostQuery();
  $hostQ->connect();
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }

  $hostQ = new LookupHostQuery();
  $hostQ->connect();
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }

  return $hostQ->delete($set);
}

function makeHostDataSet($array) {
  $set = new LookupHosts();
  $set->setSeq(0 + $array["seq"]);
  $set->setActive($array["active"] == 'y' ? 'y' : 'n');
  $set->setId(0 + $array["id"]);
  $set->setHost($array["host"]);
  $set->setName($array["name"]);
  $set->setDb($array["db"]);
  $set->setUser($array["user"]);
  $set->setPw($array["pw"]);
  $set->setCharset($array["charset"]);
  
  return $set;
}

function validateHostData($set) {
  $required = array('Active', 'Host', 'Db', 'Name');
  foreach ($required as $field) {
    $method = 'get' . $field;
    $val = $set->$method();
    
    if (empty($val)) {
      return false;
    }
  }
  return true;
}

function updateHost ($array) {
  $hostQ = new LookupHostQuery();
  $hostQ->connect();
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }

  $set = makeHostDataSet($array);
  if (validateHostData($set)) {
    return $hostQ->update($set);
  }
  else {
    return false;
  }
}

function insertHost ($array) {
  $hostQ = new LookupHostQuery();
  $hostQ->connect();
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }

  $set = makeHostDataSet($array);
  if (validateHostData($set)) {
    return $hostQ->insert($set);
  }
  else {
    return false;
  }
}

function getHosts ($mode) {
  global $postVars;
  
  $hostQ = new LookupHostQuery();
  $hostQ->connect();
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }
  if ($mode == 'all') {
    $hostQ->execSelectAll();
  }
  else {
    $hostQ->execSelect();
  }
  if ($hostQ->errorOccurred()) {
    $hostQ->close();
    displayErrorPage($hostQ);
  }
  $n = 0;
  $hosts = array();
  while ($row = $hostQ->fetchRow()) {
    $hosts[$n]['id']=$row->getId();
    $hosts[$n]['seq']=$row->getSeq();
    $hosts[$n]['active']=$row->getActive();
    $hosts[$n]['host']=$row->getHost();
    $hosts[$n]['name']=$row->getName();
    $hosts[$n]['db']=$row->getDb();
    $hosts[$n]['user']=$row->getUser();
    $hosts[$n]['pw']=$row->getPw();
    $hosts[$n]['charset']=$row->getCharset();
    $n++;
  }
  $postVars['hosts'] = $hosts;
  $postVars['numHosts'] = $n;

  $hostQ->close();
}
?>
