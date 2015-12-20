<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/4/15
 * Time: 4:23 PM
 */

namespace Adr\Response;

use Adr\Response\Date\ExpireDate;
use Adr\Response\Date\IssueDate;
use Adr\Response\License\Restriction;
use Adr\Response\License\Status;

class LicenseNode
{

    private $type;
    private $issuetype;
    private $class;
    private $classcode;
    private $expiredate;
    private $issuedate;
    private $statuses;
    private $restrictions;

    public function __construct($xmlNode)
    {
        $this->statuses = array();
        $this->restrictions = array();
        foreach ($xmlNode->childNodes as $element) {
            if (!$element instanceof \DOMText) {
                switch (strtoupper($element->nodeName)) {
                    case 'STATUSES':
                        $this->{strtolower($element->nodeName)}[] = new Status($element);
                        break;
                    case 'RESTRICTIONS':
                        $this->{strtolower($element->nodeName)}[] = new Restriction($element);
                        break;
                    case 'EXPIREDATE':
                        $this->{strtolower($element->nodeName)} = new ExpireDate($element);
                        break;
                    case 'ISSUEDATE':
                        $this->{strtolower($element->nodeName)} = new IssueDate($element);
                        break;
                    default:
                        $this->{strtolower($element->nodeName)} = $element->nodeValue;
                        break;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getIssuetype()
    {
        return $this->issuetype;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getClasscode()
    {
        return $this->classcode;
    }

    /**
     * @return mixed
     */
    public function getExpiredate()
    {
        return $this->expiredate;
    }

    /**
     * @return mixed
     */
    public function getIssuedate()
    {
        return $this->issuedate;
    }

    /**
     * @return mixed
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @return mixed
     */
    public function getRestrictions()
    {
        return $this->restrictions;
    }
}
