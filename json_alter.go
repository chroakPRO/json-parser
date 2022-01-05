package main

import (
	`encoding/json`
	`fmt`
	`io/ioutil`
	`os`
)

type Heads struct{
	Heads 			[]Items	`json:"items"`
}

type Login struct {
	Username		string	`json:"username"`
	Password		string	`json:"Password"`
	Totp			string	`json:"totp"`
}

type Items struct {
	Id				string 	`json:"id"`
	OrganizationId	string 	`json:"OrganizationId"`
	FolderId		string 	`json:"folderId"`
	Reprompt		int 	`json:"reprompt"`
	Name			string 	`json:"name"`
	Notes			string	`json:"notes"`
	Favorite		string 	`json:"favorite"`
	Login 			Login	`json:"login"`
	Username		string	`json:"username"`

}



func main() {

	jsonFile, err := os.Open("bitwarden_export.json")
	if err != nil {
		fmt.Println(err)
	}

	fmt.Println("Successfully Opened json file")
	defer jsonFile.Close()

	byteEmpValue, _ := ioutil.ReadAll(jsonFile)

	var heads Heads

	json.Unmarshal(byteEmpValue, &heads)


	for i := 0; i < len(heads.Heads); i++ {
		fmt.Pr	intf("Employee Name: " + heads.Heads[i].Login.Password)
		//fmt.Println("Employee Gender: " + employees.Employees[i].Gender)
		//fmt.Println("Employee Age: " + strconv.Itoa(employees.Employees[i].Age))
	}










	/*
	// Open our jsonFile
	jsonFile, err := os.Open("bitwarden_export.json")
	// if we os.Open returns an error then handle it
	if err != nil {
		fmt.Println(err)
	}
	fmt.Println("Successfully Opened users.json")
	// defer the closing of our jsonFile so that we can parse it later on
	defer jsonFile.Close()

	byteValue, _ := ioutil.ReadAll(jsonFile)

	var result interface{}
	json.Unmarshal([]byte(byteValue), &result)

	fmt.Println(result.(map[string]interface{})["items"].string["login"])*/

	}

