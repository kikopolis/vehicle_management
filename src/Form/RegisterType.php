<?php

declare(strict_types = 1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;

final class RegisterType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('name', TextType::class, [
				'label' => 'forms.fields.name',
				'attr'  => ['placeholder' => 'forms.fields.name'],
			])
			->add('email', TextType::class, [
				'label' => 'forms.fields.email',
				'attr'  => ['placeholder' => 'forms.fields.email'],
			])
			->add('plainPassword', PasswordType::class, [
				'label' => 'forms.fields.password',
				'attr'  => ['placeholder' => 'forms.fields.password'],
				'help'  => 'forms.fields.password.requirements',
			])
			->add('repeatPlainPassword', PasswordType::class, [
				'label' => 'forms.fields.password.repeat',
				'attr'  => ['placeholder' => 'forms.fields.password.repeat'],
				'help'  => 'forms.fields.password.repeat.requirements',
			])
			->add('locale', ChoiceType::class, [
				'label'   => 'forms.fields.locale',
				'choices' => ['English' => 'en', 'Estonian' => 'et'],
			])
			->add('agreeToTerms', CheckboxType::class, [
				'mapped'      => false,
				'required'    => true,
				'label'       => ' ',
				'constraints' => [
					new IsTrue(['message' => 'forms.fields.checkbox.agree.to.terms.agreed']),
					new Required(),
					new NotNull(['message' => 'forms.fields.checkbox.agree.to.terms.not.null']),
				],
			])
			->add('register', SubmitType::class, ['label' => 'Register'])
		;
	}
	
	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults(
			[
				'data_class'        => User::class,
				'validation_groups' => 'register',
			]
		);
	}
}
