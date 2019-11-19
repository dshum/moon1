<?php

use Moonlight\Main\Site;
use Moonlight\Main\Item;
use Moonlight\Main\Element;
use Moonlight\Main\Rubric;
use Moonlight\Properties\BaseProperty;
use Moonlight\Properties\MainProperty;
use Moonlight\Properties\OrderProperty;
use Moonlight\Properties\CheckboxProperty;
use Moonlight\Properties\DatetimeProperty;
use Moonlight\Properties\DateProperty;
use Moonlight\Properties\FloatProperty;
use Moonlight\Properties\ImageProperty;
use Moonlight\Properties\IntegerProperty;
use Moonlight\Properties\OneToOneProperty;
use Moonlight\Properties\ManyToManyProperty;
use Moonlight\Properties\PasswordProperty;
use Moonlight\Properties\RichtextProperty;
use Moonlight\Properties\TextareaProperty;
use Moonlight\Properties\TextfieldProperty;
use Moonlight\Properties\PluginProperty;
use Moonlight\Properties\VirtualProperty;

$site = \App::make('site');

$site->

    /*
	 * Раздел сайта
	 */

	addItem(
		Item::create('App\Section')->
		setTitle('Раздел сайта')->
		setRoot(true)->
        setCreate(true)->
		setElementPermissions(true)->
		addOrder()->
		addProperty(
			MainProperty::create('name')->
			setTitle('Название')->
			setRequired(true)
		)->
		addProperty(
			TextfieldProperty::create('url')->
			setTitle('Адрес страницы')->
            setRequired(true)->
			addRule('regex:/^[a-z0-9\-]+$/i', 'Допускаются латинские буквы, цифры и дефис.')
		)->
		addProperty(
			TextfieldProperty::create('title')->
			setTitle('Title')->
			setShow(true)->
			setEditable(true)
		)->
		addProperty(
			TextfieldProperty::create('h1')->
			setTitle('H1')->
			setShow(true)->
			setEditable(true)
		)->
		addProperty(
			TextfieldProperty::create('meta_keywords')->
			setTitle('META Keywords')->
			setShow(true)->
			setEditable(true)
		)->
		addProperty(
			TextareaProperty::create('meta_description')->
			setTitle('META Description')->
			setShow(true)->
			setEditable(true)
		)->
		addProperty(
			RichtextProperty::create('fullcontent')->
			setTitle('Текст раздела')
		)->
        addProperty(
			OneToOneProperty::create('section_id')->
			setTitle('Раздел сайта')->
			setRelatedClass('App\Section')->
			setParent(true)
		)->
		addTimestamps()->
		addSoftDeletes()
	)->

	/*
	 * Служебный раздел
	 */

	addItem(
		Item::create('App\ServiceSection')->
		setTitle('Служебный раздел')->
		setRoot(true)->
        setCreate(true)->
		setElementPermissions(true)->
		addOrder()->
		addProperty(
			MainProperty::create('name')->
			setTitle('Название')->
			setRequired(true)
		)->
		addProperty(
			OneToOneProperty::create('service_section_id')->
			setTitle('Служебный раздел')->
			setRelatedClass('App\ServiceSection')->
			setParent(true)->
            setOpenItem(true)->
			setShow(true)
		)->
		addTimestamps()->
		addSoftDeletes()
	)->

	/*
	 * Настройки сайта
	 */

	addItem(
		Item::create('App\SiteSettings')->
		setTitle('Настройки сайта')->
		setRoot(true)->
		setCreate(true)->
		addProperty(
			MainProperty::create('name')->
			setTitle('Название')->
			setRequired(true)
		)->
		addProperty(
			TextfieldProperty::create('title')->
			setTitle('Title')->
			setRequired(true)->
			setShow(true)
		)->
        addProperty(
			TextfieldProperty::create('meta_keywords')->
			setTitle('META Keywords')->
			setShow(true)
		)->
		addProperty(
			TextareaProperty::create('meta_description')->
			setTitle('META Description')->
			setShow(true)
		)->
		addTimestamps()->
		addSoftDeletes()
	)->

    /*
	 * Пользователь
	 */

	addItem(
		Item::create('App\User')->
		setTitle('Пользователь')->
        setCreate(true)->
        setPerPage(10)->
        addOrderBy('created_at', 'desc')->
		addProperty(
			MainProperty::create('email')->
			setTitle('E-mail')->
			addRule('email', 'Некорректный адрес электронной почты')->
			setRequired(true)
		)->
		addProperty(
			PasswordProperty::create('password')->
			setTitle('Пароль')
		)->
        addProperty(
			TextfieldProperty::create('first_name')->
			setTitle('Имя')->
			setRequired(true)->
			setShow(true)->
			setEditable(true)
		)->
        addProperty(
			TextfieldProperty::create('last_name')->
			setTitle('Фамилия')->
			setRequired(true)->
			setShow(true)->
			setEditable(true)
		)->
        addProperty(
			OneToOneProperty::create('service_section_id')->
			setTitle('Служебный раздел')->
			setRelatedClass('App\ServiceSection')->
			setRequired(true)->
			setParent(true)->
            setOpenItem(true)
		)->
		addTimestamps()->
		addSoftDeletes()
	)->

	/*
	 * Сообщение
	 */

	addItem(
		Item::create('App\Message')->
		setTitle('Сообщение')->
        addOrderBy('created_at', 'desc')->
		addProperty(
			MainProperty::create('name')->
			setTitle('Название')
		)->
		addProperty(
			TextareaProperty::create('message')->
			setTitle('Текст сообщения')->
			setRequired(true)->
			setShow(true)
		)->
		addProperty(
			TextfieldProperty::create('face')->
			setTitle('Имя')->
			setRequired(true)->
			setShow(true)
		)->
        addProperty(
			TextfieldProperty::create('email')->
			setTitle('E-mail')->
			addRule('email', 'Некорректный адрес электронной почты')->
			setRequired(true)->
			setShow(true)
		)->
        addProperty(
            TextfieldProperty::create('recaptcha_response')->
            setTitle('Recaptcha')->
            setShow(true)
        )->
        addProperty(
            TextfieldProperty::create('ip')->
            setTitle('IP')->
            setShow(true)
        )->
        addProperty(
			OneToOneProperty::create('service_section_id')->
			setTitle('Служебный раздел')->
			setRelatedClass('App\ServiceSection')->
			setRequired(true)->
			setParent(true)->
            setOpenItem(true)
		)->
		addTimestamps()->
		addSoftDeletes()
	)->

	bind(Site::ROOT, ['App.Section', 'App.ServiceSection', 'App.SiteSettings'])->
	bind('App.ServiceSection.2', 'App.Message')->

	addRubric(
		Rubric::create('service_sections', 'Служебные разделы')->
		bind([
			Site::ROOT => 'App.ServiceSection'
		])
	)->
	/*
	addRubric(
		Rubric::create('site_settings', 'Настройки сайта')->
		bind('App.SiteSettings')
	)->
	*/

	end();
