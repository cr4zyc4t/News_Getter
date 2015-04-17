<?php exit("Permission Denied"); ?>
2014-12-01 03:26:41
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{

}.group("IP")',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 03:26:58
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
IP: *
}.group("IP")',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 03:27:00
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
IP: *
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 03:27:01
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
IP: *
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:44:28
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"client_Id": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:44:34
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
client_Id: "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:44:44
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
Request-Params.client_Id: "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:52:36
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:53:02
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : {"$ne": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:53:41
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : {"$exist": false}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:53:44
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : {"$ne": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:54:03
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : {$exist: false}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:54:05
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : {"$ne": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:54:27
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
"Request-Params.client_Id" : "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:54:59
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:55:36
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": {$exist: true}
}.count()',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:55:46
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": {\'$exist\': true}
}.count()',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:55:51
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": {$exist: true}
}.count()',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:55:51
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:55:59
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}.count()',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:56:05
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": "Jby7xjhF4lg1xi64LN2EbeuTFOr7aNRI"
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:57:12
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": {\'$exists\' : false}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
2014-12-01 04:57:20
array (
  'db' => 'cms',
  'collection' => 'tracking',
  'action' => 'collection.index',
  'format' => 'json',
  'criteria' => '{
	"Request-Params.client_Id": {\'$exists\' : true}
}',
  'newobj' => '{
	\'$set\': {
		//your attributes
	}
}',
  'field' => 
  array (
    0 => '_id',
    1 => '',
    2 => '',
    3 => '',
  ),
  'order' => 
  array (
    0 => 'desc',
    1 => 'asc',
    2 => 'asc',
    3 => 'asc',
  ),
  'limit' => '0',
  'pagesize' => '10',
  'command' => 'findAll',
)
================
