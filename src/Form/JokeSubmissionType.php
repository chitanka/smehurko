<?php namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JokeSubmissionType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title')
			->add('content')
			->add('themes')
			->add('source')
			->add('save', SubmitType::class)
		;
	}
}
