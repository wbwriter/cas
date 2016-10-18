<?php

class Newsletter
{
    private $emailAddress;
    private $subscriptionTimestamp;

    function __construct($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    public static function subscribe($email)
    {
        $query = "INSERT INTO `subscribers`(`emailAddress`) VALUES ('$email');";
        return MySqlConn::getInstance()->insertAndGetID($query);
    }

    public static function unsubscribe($email)
    {
        $query = "DELETE FROM `subscribers` WHERE emailAddress = '$email'";
        return MySqlConn::getInstance()->executeQuery($query);
    }

    public static function getSubscribers()
    {
        $emailAddresses = array();
        $query = "SELECT emailAddress FROM `subscribers`";
        $result = MySqlConn::getInstance()->selectDB($query);
        $rows = $result->fetchAll();

        foreach($rows as $row)
        {
            $emailAddress = $row[0];
            array_push($emailAddresses, $emailAddress);
        }
        return $emailAddresses;
    }


    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param mixed $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionTimestamp()
    {
        return $this->subscriptionTimestamp;
    }
}