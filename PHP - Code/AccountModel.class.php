<?php
/**
 *? [Description]
 ** Every JSON object will be parsed and placed into an AccountDetail object
 * 
 * @version ${1:1.0.0
 * @author Cooper <coopersec@protonmail.com>
 * 
 */
 class AccountDetail  {

    //* PUBLIC DATA
    public string $id_main, $id_hash, $username, $password, $name;

    //! PUBLIC DATA
    public array $refrence;

    /** 
     ** ['Constructor'] //! RUNS FIRST
     */
    public function __construct() {
        
        //* Default values. 
        $this->id_main = 0;
        $this->id_hash = 0;
        $this->username = "none";
        $this->password = "none";
        $this->name = "none";

        //* Array: Hold all object values. (not sorted)
        $this->reference = array($this->username, $this->id_hash,
         $this->username, $this->password, $this->name);
    }

    /**
     * * ['When object gets printed.']
     * @return [string]
     */
    public function __toString() {

        //* String: Can be used to return values as strings. Without converting
        return "struct-object blueprint. Nothing more to see here....";
    }

    /**
     * * Invoke method
     * @return [string]
     */
    public function _invoke() {
        
        return 'Invoke is not allowed.';
    }

    /**
     * * ['function call:: seralize()']
     * @return array
     * ? Info: This is for testing purposes.
     */
    public function __seralize(): array 
    {
        
       //* JSON Structure: No info needed..
        return [
            'id'       => $this->id_main,
            'hash'     => $this->id_hash,
            'username' => $this->username,
            'password' => $this->password,
            'name'     => $this->name,
            'ref'      => $this->reference,
        ];

    }

    /**
     * * ['function call: unserialize()']
     * 
     * @param array $data
     * 
     * ?Info: For testing purposes.
     * @return void
     */
    public function __unserialize(array $data): void
    {
        //* Converts php object to JSON.
        $this->id_main = $data['id_main'];
        $this->id_hash = $data['hash'];
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->name = $data['name'];
        $this->reference = $data['reference'];
    }
}
?>