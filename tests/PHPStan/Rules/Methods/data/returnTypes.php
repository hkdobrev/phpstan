<?php

namespace ReturnTypes;

class Foo extends FooParent implements FooInterface
{

	public function returnNothing()
	{
		return;
	}

	public function returnInteger(): int
	{
		return 1;
		return 'foo';
		$foo = function () {
			return 'bar';
		};
	}

	public function returnObject(): Bar
	{
		return 1;
		return new self();
		return new Bar();
	}

	public function returnChild(): self
	{
		return new self();
		return new FooChild();
		return new OtherInterfaceImpl();
	}

	/**
	 * @return string|null
	 */
	public function returnNullable()
	{
		return 'foo';
		return null;
	}

	public function returnInterface(): FooInterface
	{
		return new self();
	}

	/**
	 * @return void
	 */
	public function returnVoid()
	{
		return;
		return null;
		return 1;
	}

	/**
	 * @return static
	 */
	public function returnStatic(): FooParent
	{
		return parent::returnStatic();

		$parent = new FooParent();
		return $parent->returnStatic(); // the only case with wrong static base class
		return $this->returnStatic();
	}

	public function returnAlias(): Foo
	{
		return new FooAlias();
	}

	public function returnAnotherAlias(): FooAlias
	{
		return new Foo();
	}

	/**
	 * @param self[]|Collection $collection
	 * @return self[]|Collection
	 */
	public function returnUnionIterableType($collection)
	{
		return $collection;
		return new Collection();
		return new self();
		return [new self()];
		return new Bar();
		return [new Bar()];
		return 1;
		return;

		/** @var Bar[]|Collection $barListOrCollection */
		$barListOrCollection = doFoo();
		return $barListOrCollection;

		/** @var self[]|AnotherCollection $selfListOrAnotherCollection */
		$selfListOrAnotherCollection = doFoo();
		return $selfListOrAnotherCollection;

		/** @var self[]|Collection|AnotherCollection $selfListOrCollectionorAnotherCollection */
		$selfListOrCollectionorAnotherCollection = doFoo();
		return $selfListOrCollectionorAnotherCollection;

		/** @var Bar[]|AnotherCollection $completelyDiffernetUnionIterable */
		$completelyDiffernetUnionIterable = doFoo();
		return $completelyDiffernetUnionIterable;

		return null;
	}

	/**
	 * @param self[]|Collection $collection
	 * @return self[]|Collection|OtherCollection|null
	 */
	public function returnUnionIterableLooserReturnType($collection)
	{
		return $collection;
		return null;
	}

	/**
	 * @return $this
	 */
	public function returnThis(): self
	{
		return $this;
		return new self();
		return 1;
		return null;

		$that = $this;
		return $that;
	}

	/**
	 * @return $this|null
	 */
	public function returnThisOrNull()
	{
		return $this;
		return new self();
		return 1;
		return null;
		return $this->returnThis();
		return $this->returnStaticThatReturnsNewStatic();
	}

	/**
	 * @return static
	 */
	public function returnStaticThatReturnsNewStatic(): self
	{
		return new static();
		return $this;
	}

	public function returnsParent(): parent
	{
		return new FooParent();
		return 1;
		return null;
	}

	public function returnsPhpDocParent(): parent
	{
		return new FooParent();
		return 1;
		return null;
	}

	/**
	 * @return scalar
	 */
	public function returnScalar()
	{
		return 1;
		return 10.1;
		return 'a';
		return false;
		return new \stdClass();
	}

	/**
	 * @return int
	 */
	public function containsYield()
	{
		yield 1;
		return;
	}

	public function returnsNullInTernary(): int
	{
		/** @var int|null $intOrNull */
		$intOrNull = doFoo();
		return $intOrNull;
		return $intOrNull !== null ? $intOrNull : 5;
		return $intOrNull !== null ? $intOrNull : null;
	}

	public function misleadingBoolReturnType(): boolean
	{
		return true;
		return 1;
		return new boolean();
	}

	public function misleadingIntReturnType(): integer
	{
		return 1;
		return true;
		return new integer();
	}

	public function misleadingMixedReturnType(): mixed
	{
		return 1;
		return true;
		return new mixed();
	}
}

class FooChild extends Foo
{

}

class Stock
{

	/** @var self */
	private $stock;

	/** @var self|null */
	private $nullableStock;

	public function getActualStock(): self
	{
		if (is_null($this->stock))
		{
			$this->stock = $this->findStock();
			if (is_null($this->stock)) {
				throw new \Exception();
			}
			return $this->stock;
		}
		return $this->stock;
	}

	/**
	 * @return self|null
	 */
	public function findStock()
	{
		return new self();
	}

	public function getAnotherStock(): self
	{
		return $this->findStock();
	}

	public function returnSelf(): self
	{
		$stock = $this->findStock();
		if ($stock === null) {
			$stock = new self();
		}

		return $stock;
	}

	public function returnSelfAgain(): self
	{
		$stock = $this->findStock();
		if ($stock === null) {
			$stock = new self();
		} elseif (test()) {
			doFoo();
		}

		return $stock;
	}

	public function returnSelfYetAgain(): self
	{
		$stock = $this->findStock();
		if ($stock === null) {
			$stock = new self();
		} elseif (test()) {
			doFoo();
		} else {
			doBar();
		}

		return $stock;
	}

	public function returnSelfYetYetAgain(): self
	{
		if ($this->nullableStock === null) {
			$this->nullableStock = new self();
		}

		return $this->nullableStock;
	}

}

class Issue105
{
	/**
	 * @param string $type
	 *
	 * @return array|float|int|null|string
	 */
	public function manyTypes(string $type)
	{

	}

	/**
	 * @return array
	 */
	public function returnArray(): array
	{
		$result = $this->manyTypes('array');
		$result = is_array($result) ? $result : [];

		return $result;
	}

	public function returnAnotherArray(): array
	{
		$result = $this->manyTypes('array');
		if (!is_array($result)) {
			$result = [];
		}

		return $result;
	}
}
