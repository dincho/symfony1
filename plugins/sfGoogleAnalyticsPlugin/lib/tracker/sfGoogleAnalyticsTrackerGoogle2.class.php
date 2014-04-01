<?php

/**
 * Google Analytics v2 ga.js tracker.
 *
 * @package     sfGoogleAnalyticsPlugin
 * @subpackage  tracker
 */
class sfGoogleAnalyticsTrackerGoogle2 extends sfGoogleAnalyticsTracker
{

    /**
     * @see sfGoogleAnalyticsTracker
     */
    public function insert(sfResponse $response)
    {
        $html = array();

        $html[] = '<script type="text/javascript">';
        $html[] = '//<![CDATA[';
        $html[] = 'var _gaq = _gaq || [];';

        $html[] = sprintf("_gaq.push(['_setAccount', %s]);", $this->escape($this->getProfileId()));

        if ($domainName = $this->getDomainName()) {
            $html[] = sprintf("_gaq.push(['_setDomainName', %s]);", $this->escape($domainName));
        }

        if ($this->getLinkerPolicy()) {
            $html[] = "_gaq.push(['_setAllowLinker', true]);";
        }

        if ($pageName = $this->getPageName()) {
            $html[] = sprintf("_gaq.push(['_trackPageview', %s]);", $this->escape($pageName));
        } else {
            $html[] = "_gaq.push(['_trackPageview']);";
        }

        if ($after = $this->getAfterTrackerJS()) {
            $html[] = $after;
        }

        $html[] = "(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();";
        $html[] = '//]]>';
        $html[] = '</script>';
        $html = join("\n", $html);
        $this->doInsert($response, $html, $this->insertion);
    }

    /**
     * @see sfGoogleAnalyticsTracker
     */
    public function forgePageViewFunction($path = null, $options = array())
    {
        $this->prepare($path, $options);

        if (isset($options['is_event']) && $options['is_event']) {
            $func = "_gaq.push(['_trackEvent', %s]);";
        } else {
            $func = "_gaq.push(['_trackPageview', %s]);";
        }

        return sprintf($func, $this->escape($path));
    }

    /**
     * @see sfGoogleAnalyticsTracker
     */
    public function forgeLinkerFunction($url, $options = array())
    {
        return sprintf("_gaq.push(['_link', %s]);", $this->escape($url));
    }

    /**
     * @see sfGoogleAnalyticsTracker
     */
    public function forgePostLinkerFunction($formElement = 'this')
    {
        return sprintf("_gaq.push(['_linkByPost', %s]);", $formElement);
    }

}
