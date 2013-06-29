<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Helper to generate HTML markup complying with ZURB Foundation's section plugin.
 * This class assumes that you have loaded the foundation.section.js file and
 * Foundation CSS.
 * 
 * See Foundation's documentation: http://foundation.zurb.com/docs/components/section.html
 */
class FoundationSectionHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	/**
	 * Generate the whole set of sections.
	 * @param string $class to apply to section
	 * @param array $sections each element should have a title and content
	 * attribute to be used in generating the sections.
	 * @return string sections HTML
	 */
	public function wholeSection($class = 'auto', $sections = array()) {
		$sectionsHtml = '';
		$count = 1;
		foreach ($sections as $section) {
			$anchor = "section"  . $count;
			$sectionsHtml .= $this->individualSection($section['title'], 
					$section['content'], $anchor);
			$count++;
		}
		$class .= ' section-container ';
		$sectionsHtml = $this->Html->div($class, $sectionsHtml, array(
				'escape' => FALSE,
				'data-section' => ''
		));
		return $sectionsHtml;
	}
	
	/**
	 * Generate an indivdual section. Can be called independently or as a
	 * part of the wholeSection call.
	 * @param string $title of the section
	 * @param string $content of the section
	 * @param string $anchor to link to a section
	 * @return string HTML for one section
	 */
	public function individualSection($title = 'Title', $content = 'Content', $anchor = '') {
		$sectionHtml = '';
		$sectionHtml .= $this->Html->tag('p', $this->Html->link($title,
				array(
						'controller' => $this->request->controller,
						'action' => $this->request->action,
						'#' => $anchor)
				), array(
						'escape' => FALSE,
						'class' => 'title'
				));
		$sectionHtml .= $this->Html->div('content', $content, array(
				'escape' => FALSE
		));
		$sectionHtml = $this->Html->tag('section', $sectionHtml, array(
				'escape' => FALSE,
				'class' => 'section'
		));
		return $sectionHtml;
	}
}
