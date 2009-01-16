#!/bin/env python
################################################################################################
#	API ACCESS PHP/PY Copyright 2009 TechnologyAZ, LLC and Blaine Schanfeldt
#	Version 0 - 1/16/09
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
domain = sys.argv[2]+'.'
ip = sys.argv[3]
mxtype = sys.argv[4]

api_site = 'https://%s@api.slicehost.com/' % api_password

class Zone(ActiveResource):
	_site = api_site

class Record(ActiveResource):
	_site = api_site

# Creating a new Zone

zone = Zone({'origin':domain, 'ttl':3000, 'active':'Y'})
zone.save()

# Creating a record for that Zone
record = Record({'record_type':'NS', 'zone_id':zone.id, 'name':domain, 'data':'ns1.slicehost.net'})
record.save()
record = Record({'record_type':'NS', 'zone_id':zone.id, 'name':domain, 'data':'ns2.slicehost.net'})
record.save()
record = Record({'record_type':'NS', 'zone_id':zone.id, 'name':domain, 'data':'ns3.slicehost.net'})
record.save()

record = Record({'record_type':'A', 'zone_id':zone.id, 'name':domain, 'data':ip})
record.save()
if mxtype == "1":
	record = Record({'record_type':'A', 'zone_id':zone.id, 'name':'mail.'+domain, 'data':ip})
	record.save()
if mxtype == "2":
	record = Record({'record_type':'CNAME', 'zone_id':zone.id, 'name':'webmail.'+domain, 'data':'ghs.google.com.'})
	record.save()
	
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'alt1.aspmx.l.google.com.', 'aux':1})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'aspmx.l.google.com.', 'aux':5})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'alt2.aspmx.l.google.com.', 'aux':5})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'aspmx2.googlemail.com.', 'aux':10})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'aspmx3.googlemail.com.', 'aux':10})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'aspmx4.googlemail.com.', 'aux':10})
	record.save()
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'aspmx5.googlemail.com.', 'aux':10})
	record.save()
if mxtype == "1":
	record = Record({'record_type':'MX', 'zone_id':zone.id, 'name':domain, 'data':'mail.'+domain, 'aux':10})
	record.save()
if mxtype == "2":
	record = Record({'record_type':'TXT', 'zone_id':zone.id, 'name':domain, 'data':'v=spf1 include:aspmx.googlemail.com ~all'})
	record.save()

print "1"