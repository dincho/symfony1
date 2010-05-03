<?php

/**
 * geo2seo actions.
 *
 * @package    PolishRomance
 * @subpackage geo2seo
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class geo2seoActions extends sfActions
{

    public function preExecute()
    {
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Countries', 'uri' => '@seo_countries'));
    }
    
    public function executeIndex()
    {
        //this shows all countries
        $countries = GeoPeer::getCountriesArray();
        $first_column_rows = 85;
        $second_column_rows = 82;
        $countries_columns['left'] = array_slice($countries, 0, $first_column_rows, true); //left 
        $countries_columns['middle'] = array_slice($countries, $first_column_rows, $second_column_rows, true); //middle
        $countries_columns['right'] = array_slice($countries, $first_column_rows+$second_column_rows); //right
        $this->countries_columns = $countries_columns;
        
        if( $page = StaticPagePeer::getBySlug('seo_countries') )
        {
            $this->getResponse()->setTitle($page->getTitle());
            $this->getResponse()->addMeta('description', $page->getDescription());
            $this->getResponse()->addMeta('keywords', $page->getKeywords());
        }        
    }

    public function executeCountry()
    {
        //this show all adm1 of the country
        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $this->getRequestParameter('country_iso'));
        $c->add(GeoPeer::DSG, 'ADM1');

        $this->adms = GeoPeer::doSelect($c);
        $this->rows_per_column = count($this->adms)/5; //5 columns
        $this->country_iso = $this->getRequestParameter('country_iso');
        $this->country_name = $this->getRequestParameter('country_name');
        
        $this->getUser()->getBC()->replaceLast(array('name' => $this->country_name, 
                                                    'uri' => '@country_info?country_iso=' . $this->country_iso . '&name='. $this->country_name));
                                                            
    }

    public function executeAdm1Info()
    {
        $adm1 = GeoPeer::getAdm1ByCountryAndPK($this->getRequestParameter('country_iso'), $this->getRequestParameter('adm1_id'));
        $this->forward404Unless($adm1);
        
        $bc = $this->getUser()->getBC();
        $uri = $this->getController()->genUrl('@country_info?country_iso=' . $this->getRequestParameter('country_iso') . 
                                                                            '&country_name='. $this->getRequestParameter('country_name'), true);
        $bc->replaceLast(array('name' => $this->getRequestParameter('country_name'), 
                                                    'uri' => $uri));

        $bc->add(array('name' => $adm1->getName()));
        $this->adm1 = $adm1;
        $this->photo = StockPhotoPeer::getJoinNowPhotoByCulture($this->getUser()->getCulture());
    }
}
