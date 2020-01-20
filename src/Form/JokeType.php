<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JokeType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title')
			->add('subtitle')
			->add('content')
			->add('themes')
			->add('source')
			->add('save', SubmitType::class)
		;
	}
}
