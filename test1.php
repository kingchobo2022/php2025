
abstract class Animal {
	abstract public function makeSound();
	
	public function ea() {
		echo "Eating <br>";
	}
}

class Dog extends Animal {
	public function makeSound() {
		echo "Bark <br>";
	}
}

class Cat extends Animal {
	public function makeSound() {
		echo "Neow <br>";
	}
}

$dog = new Dog();
$dog->makeSound();

$cat = new Cat();
$cat->makeSound();


