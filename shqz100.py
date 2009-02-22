#!/bin/env python
################################################################################################
#	Slicehost Quick Zone Creator - Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt
#	Version 1.00 - 2/22/09
#	Code License:  	 MIT License - http://www.opensource.org/licenses/mit-license.php
#
#	REQUIRES pyactiveresource by Jared Kuolt - http://code.google.com/p/pyactiveresource/
################################################################################################
import sys
from pyactiveresource.activeresource import ActiveResource
import urllib
#from xml.dom import minidom
import xml.dom

api_password = sys.argv[1]
domain = sys.argv[2]
ip = sys.argv[3]
template = sys.argv[4]
astr = []
log = []

api_site = 'https://%s@api.slicehost.com/' % api_password

class Zone(ActiveResource):
	_site = api_site

class Record(ActiveResource):
	_site = api_site

# Creating a new Zone

zone = Zone({'origin':domain, 'ttl':3000, 'active':'Y'})
zone.save()

f = open('../../'+template, 'r')
t = f.read()
t = t.replace('example.com', domain)
t = t.replace('0.0.0.0', ip)
arr = t.split("\n")
for v in arr:
    astr.append(v.split("\t"))
for v in astr:
	record = Record({'active':v[0],'record_type':v[1], 'zone_id':zone.id, 'name':v[2], 'data':v[3], 'aux':v[4], 'ttl':v[5]})
	record.save()
	log.append(v[1]+'	'+v[2]+'	'+v[3]+'	'+v[4]+' - Success!')
for v in log:
	print v