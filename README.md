# dustin/dto
A simple and small php library to create data transfer objects easily. It brings a bunch of methods to access fields/properties and set or get their values.
Their are two types of DTOs which can be used:

 1. Those that store their data within an array
 2. Those that store their data in object properties

## General

**ArrayAccess**
You can use all DTOs like an array, like:

    $dto = new Dto();
    $dto['foo'] = $foo;
    $bar = $dto['bar'];
    
**Iterator**
You can iterate over all fields/properties of a DTO:

    $dto = new Dto(['foo' => $foo, 'bar' => $bar]);
    
    foreach($dto as $field => $value) {
	    // do something
    }
    
**JsonSerializable and serialization**
Each DTO is serializable and unserializable or `json_encode`-able.

**Cloning**
Cloning a DTO will also clone it's inner objects.

## Create a DTO

**Array-based DTOs**
You can use the `Dustin\Dto\Dto` class for creating flexible DTOs which can hold any value.

    use Dustin\Dto\Dto;
    
    $dto = new Dto(['foo' => $foo]);
    
**Restrict inner objects to other DTOs**
For some reasons like serialization you can restrict inner objects of a DTO to other DTOs using the `NestedDto`

    use Dustin\Dto\NestedDto;
    
    $dto = new NestedDto();
    
    $dto->set('bar', new AnyObject()); 
    // will throw an exception if AnyObject does not inherit from NestedDto
    
**Restrict fields**
Inheriting from `Dto` or from `NestedDto` allows to restrict the fields your class can hold:

    class MyDto extends Dto {
	    public function getAllowedFields(): ?array {
		    return ['foo', 'bar'];
	    }
    }
    
    $dto = new MyDto(['foo' => $foo]);
    
    $dto->set('hello', 'world');
    // will throw an exception since field 'hello' is not allowed

**Create DTOs with properties**
If you want to create a DTO class which holds it's data in properties inherit from `Dustin\Dto\PropertyDto`.

    class MyDto extends PropertyDto {
    
	    protected $foo;
		
		public function setFoo(string $foo) {
			$this->foo = $foo;
		}
		
		public function getFoo(): ?string {
			return $this->foo;
		}
    }
Using the DTO-methods  `set()`, `get()` and `add()` will call your setter/getter-methods if available.

## Create a DTO holding a list

A container is a DTO which holds a list of elements. It does not take care of keys.

**Create a container**

	use Dustin\Dto\Container;
	
    $container = new Container();
    // or initialize with elements
    $container = new Container([$foo, $bar]);
    
**Adding and getting elements**

    $container->setElements([1,2,3]);
    
    $container->addElement(4);
    // or
    $container->add('elements', 4);
    
    $elements = $container->getElements();
    // or
    $elements = $container->get('elements');
    
**Iterate over all elements**

    $container = new Container(['foo', 'bar']);
    
    foreach($container as $element) {
	    // do something
    }

## Usage

**Create an object**
	DTOs can be initialized with values in their constructor.
	
	$dto = new Dto();
    //or
    $dto = new Dto(['foo' => $bar]);

**Setting values**

    $dto->set('foo', $foo);
    // or
    $dto['foo'] = $foo;
    
**Unsetting a value**

    $dto->unset('foo');
    // or
    unset($dto['foo']);
    
**Setting several values**

    $dto->setList([
	    'foo' => $foo,
	    'bar' => $bar
    ]);
    
**Adding a value to an array**

    $dto = new Dto([
	    'myList' => [1,2,3]
    ]);
    
    $dto->add('myList', 4);
    
**Adding several values to an array**

    $dto = new Dto([
	    'fruits' => ['grapefruit', 'carambola']
    ]);
    
    $dto->addList('fruits', ['kiwi', 'lemon']);
    
**Get a single value**

	$foo = $dto->get('foo');
    // or
    $foo = $dto['foo'];
    
**Getting several values as associative array**

    $data = $dto->getList(['foo', 'bar']);
    
**Getting all values as associative array**

    $data = $dto->toArray();
    
**Check if a field/property exists**

    $dto->has('foo');
    
**Get all fields/properties** 

    $fields = $dto->getFields();
    
**Check if a DTO is filled**

    $dto->isEmpty();
