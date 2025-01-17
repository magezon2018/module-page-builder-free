<?php
/**
 * Magezon
 *
 * This source file is subject to the Magezon Software License, which is available at https://www.magezon.com/license
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.magezon.com for more information.
 *
 * @category  Magezon
 * @package   Magezon_PageBuilderFree
 * @copyright Copyright (C) 2023 Magezon (https://www.magezon.com)
 */

namespace Magezon\PageBuilderFree\Block\Adminhtml\Helper\Form\Wysiwyg;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;

class Content extends Generic
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     * Adding editor field to render
     *
     * @return Form
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'wysiwyg_edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ],
            ]
        );

        $config['document_base_url'] = $this->getData('store_media_url');
        $config['store_id']          = $this->getData('store_id');
        $config['add_variables']     = true;
        $config['add_widgets']       = true;
        $config['add_directives']    = true;
        $config['use_container']     = true;
        $config['container_class']   = 'hor-scroll';

        $form->addField(
            $this->getData('editor_element_id'),
            'editor',
            [
                'name' => 'content',
                'style' => 'width:725px;height:460px',
                'required' => true,
                'force_load' => true,
                'config' => $this->_wysiwygConfig->getConfig($config)
            ]
        );
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
