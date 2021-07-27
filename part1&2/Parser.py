# JSON-CSV Parser v.1.0
# By Andrew Tagawa
# 11/12/2020

import json

def main():    
    # Writes headers for each file
    f1 = open("categories.csv","w")
    f1.write('"ItemID","Category"\n')
    f1.close()

    f2 = open("bids.csv","w")
    f2.write('"ItemID","UserID","Location","Country","Time","Amount"\n')
    f2.close()

    f3 = open("sellers.csv","w")
    f3.write('"ItemID","UserID"\n')
    f3.close()

    f4 = open("output.csv","w")
    f4.write('"ItemID","Name","Currently","Buy_Price","First_Bid","Number_of_Bids","Top_Bidder","Location","Country","Started","Ends","Description"\n')
    f4.close()

    f5 = open("users.csv","w")
    f5.write('"UID","Rating" \n')
    f5.close()

    # Makes a list of all IDs
    allIDs = []
    count = 0
    while count <= 39:
        data = quickOpen(count)
        count += 1
        makeItemIDList(data,allIDs)

    usedList = []   # List of all item IDs that have been used
    userList = []   # List of all people bidding or selling
    count = 0
    while count <= 4:  # Parses all of the JSON files.  Change this value to correspond with the desired # of files to process
        data = quickOpen(count)
        fn1 = 'AuctionData/items-'
        fn2 = str(count)
        fn3 = '.json'
        fn = fn1+fn2+fn3
        print("Parsing: "+fn)
        parse(data,allIDs,usedList,userList)
        count += 1

    print("All files parsed without incident! \(･ω･)/")

# Function to parse everything in a file
def parse(j,idList,usedList,userList):
    out = ""
    items = j.get("Items")
    for item in items:
        id = item.get("ItemID")
        name = item.get("Name")
        curr = item.get("Currently")
        bp = item.get("Buy_Price")
        fb = item.get("First_Bid")
        nb = item.get("Number_of_Bids")
        loc = item.get("Location")
        country = item.get("Country")
        strt = item.get("Started")
        end = item.get("Ends")
        desc = item.get("Description")

        if id in usedList: 
            print("Duplicate item ID found: "+id)
            continue
        else:
            cats = item.get("Category")
            bids = item.get("Bids")
            seller = item.get("Seller")

            if str(type(bids)) != "<class 'NoneType'>":
                parseBids(bids,id,userList)

            if str(type(cats)) == "<class 'NoneType'>":
                cats = ["None"]
            f1 = open("categories.csv","a")
            for cat in cats:
                f1.write(id+',"'+cat+'"\n')
            f1.close()

            uid = seller.get("UserID")
            makeUserList(uid,userList,seller.get("Rating"))
            if str(type(uid)) == "<class 'NoneType'>":
                uid = 0000000
            r = seller.get("Rating")
            if str(type(r)) == "<class 'NoneType'>":
                r = 0
            f3 = open("sellers.csv","a")
            f3.write(id+',"'+uid+'"\n')
            f3.close()
            out = ""
            if str(type(id)) == "<class 'NoneType'>":
                id = max(idList)+1
                print("Missing ID found.  New ID: "+id)
                idList.append(id)
            out += id+","
            if str(type(name)) == "<class 'NoneType'>":
                name = "????????"
            name = name.replace('"',"")
            name = name.replace(',',"")
            out += '"'+name+'",'
            if str(type(curr)) == "<class 'NoneType'>":
                curr = "0.00"
            curr = curr.replace("$","")
            curr = curr.replace(",","")
            curr = "0.00"
            out += curr+","
            if str(type(bp)) == "<class 'NoneType'>":
                bp = "0.00"
            bp = bp.replace("$","")
            bp = bp.replace(",","")
            out += bp +","
            if str(type(fb)) == "<class 'NoneType'>":
                fb = "0.00"
            fb = fb.replace("$","")
            fb = fb.replace(",","")
            out += fb + ","
            nb = "0"
            out += nb+',"No Bidder",'
            if str(type(loc)) == "<class 'NoneType'>":
                loc = "Undefined Location"
            loc = loc.replace('"',"")
            loc = loc.replace(",","")
            out += '"'+loc+'",'
            if str(type(country)) == "<class 'NoneType'>":
                country = "N/A"
            country = country.replace('"',"")
            country = country.replace(",","")
            out += '"'+country+'",'
            if str(type(strt)) == "<class 'NoneType'>":
                strt = "2000-01-01 00:00:00"
                out += strt+','
            else: out += convertTime(strt)+','
            if str(type(end)) == "<class 'NoneType'>":
                end = "2099-12-31 00:00:00"
                out += end+','
            else: out += convertTime(end)+','
            if str(type(desc)) == "<class 'NoneType'>":
                desc = "No description."
            desc = desc.replace('"',"")
            desc = desc.replace(',',"")
            desc = desc.replace("\n","")
            out += desc+'\n'
            f4 = open("output.csv","a")
            f4.write(out)
            f4.close()
            usedList.append(id)
            continue
    return out

# Function to facilitate the parsing of bids and their constituent fields
def parseBids(bids,id,userList):
    f_p = open("bids.csv","a")
    out = ""
    for bid in bids:
        for b in bid:
            bidder = bid.get(b)
            ref = {
                "ItemID": str(id)+",",
                "UserID": "None,",
                "Location": '"None",',
                "Country": '"None",',
                "Time": "2099-12-31 00:00:00,",
                "Amount": "0.00"
            }
            for field in bidder:
                if str(type(bidder.get(field))) == "<class 'dict'>":
                    info = bidder.get(field)
                    for thing in info:
                        insert  = info.get(thing)
                        if str(thing) == "UserID":
                            insert = str(info.get(thing))
                            u = '"'+insert+'",'
                            uid = {"UserID":u}
                            makeUserList(insert,userList,info.get("Rating"))
                            ref.update(uid)
                        elif str(thing) == "Location":
                            outstr = str(info.get(thing)).replace('"',"")
                            outstr = outstr.replace(',',"")
                            l = '"'+outstr+'",'
                            loc = {"Location":l}
                            ref.update(loc)
                        else:
                            outstr = str(info.get(thing)).replace('"',"")
                            outstr = outstr.replace(',',"")
                            cty = '"'+outstr+'",'   
                            c = {"Country":cty}
                            ref.update(c)
                else:
                    if str(field) == "Time": 
                        insert = str(bidder.get(field))
                        t = convertTime(insert)+','
                        ti = {"Time": t}
                        ref.update(ti)
                    elif str(field) == "Amount":
                        insert = str(bidder.get(field))
                        insert = insert.replace(",","")
                        insert = insert.replace("$","")
                        a = insert
                        amt = {"Amount":a}
                        ref.update(amt)
                    else:
                        iid = '"'+str(bidder.get(field))+'",'
                        itid = {"ItemID": iid}
                        ref.update(itid)
        out = str(ref["ItemID"])+str(ref["UserID"])+str(ref["Location"])+str(ref["Country"])+str(ref["Time"])+str(ref["Amount"])
        out += "\n"
    f_p.write(out)
    f_p.close()
    return out

# Facilitates opening a file for editing
def quickOpen(num):
    fn1 = 'AuctionData/items-'
    fn2 = str(num)
    fn3 = '.json'
    fn = fn1+fn2+fn3
    fp_i = open(fn)
    data = json.load(fp_i)
    fp_i.close()
    return data

# Makes a list of all item IDs
def makeItemIDList(j,iList):
    items = j.get("Items")
    for item in items:
        id = item.get("ItemID")
        if id in iList:
            print(".")
            continue
        else:
            iList.append(int(id))

# Makes a list of all item IDs
def makeUserList(uid,ulist,rating):
    if uid not in ulist:
        ulist.append(uid)
        f = open("users.csv","a")
        uidstr = str(uid.replace(",",""))
        uidstr = uidstr.replace('"',"")
        f.write('"'+uidstr+'",'+rating+'\n')
        f.close()

def convertTime(d):
    months = {
        "Jan": "01",
        "Feb": "02",
        "Mar": "03",
        "Apr": "04",
        "May": "05",
        "Jun": "06",
        "Jul": "07",
        "Aug": "08",
        "Sep": "09",
        "Oct": "10",
        "Nov": "11",
        "Dec": "12"
    }
    month = d[0:3]
    day = d[4:6]
    year = d[7:9]
    time = d [9:]
    out = ("20"+year+'-'+months[month]+'-'+day+time)
    #print(out)
    return out

main()