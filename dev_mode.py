import json
import sys
from typing import Dict, List, NewType

pass_ob = []


class PassVerify:
    
    def __init__(self, id_main: str, id_hash: str, username: str, password: str, name: str) -> object:

        self.id_main: str= id_main
        self.id_hash: str = id_hash
        self.user: str = username
        self.passw: str = password
        self.name: str = name
        self.ref: List[str] = [self.user, self.name, self.passw]

            
def list_dups(struct_list):
    
    sus_dupes = []
    dupes = []
    
    listele = len(struct_list) - 1
    
    for jndex, obj in enumerate(struct_list):
        if jndex < listele:
            for obj2 in struct_list[int(jndex + 1):]: 
                #print(obj.id_main[1])
                if str(obj.ref[0]).lower() in str(obj2.ref[0]).lower():
                    #print("first")
                    if str(obj.ref[1]) in str(obj2.ref[1]):
                        #rint("secound")
                        most = [obj, obj2]
                        sus_dupes.append(most)
                        break
    
    for j, i in enumerate(sus_dupes):
        x1 = sys.getsizeof(sus_dupes[j][0])
        x2 = sys.getsizeof(sus_dupes[j][1])
        p1 = sus_dupes[j][0].passw
        p2 = sus_dupes[j][1].passw

    

        if x1 >= x2 or p1 >= p2:
            dupes.append(sus_dupes[j][1].id_main)
        elif x2 > x1 and p2 > p1:
            dupes.append(sus_dupes[j][0].id_main)

    return dupes 
             
def main():
    v1 = "default"
    j1 = []

    
    

    with open('bitwarden_export.json') as f:
        print(f)
        data = json.load(f)
        v1 = data
        for j, i in enumerate(data["items"]):
            try:
                id_obj = j
                user_obj = data["items"][j]["login"]["username"]
                pass_obj = data["items"][j]["login"]["password"]
                id_hash = data["items"][j]["id"]
                name_obj = data["items"][j]["name"]
                pass_ob.append(PassVerify(id_obj, id_hash, user_obj, pass_obj, name_obj))
            except: True
            
        dupes = list_dups(pass_ob)

        with open('update_export.json', "r+") as f2:
            data2 = json.load(f2)
            count = 0
            #print(data2)
            for j, i in enumerate(v1["items"]):
                print(i)
                try:
                    #print(i)
                    if j in dupes:
                        a = 13
                    else:
                       data2["items"].append(v1["items"][j])
                except: pass
            data2.update()
            f2.seek(0)
            json.dump(data2, f2)

            
            FSDF
if __name__  == "__main__":
    main()
