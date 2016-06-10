from twilio.rest.lookups import TwilioLookupsClient
from twilio.rest import TwilioRestClient




#client = TwilioLookupsClient()
#number = client.phone_numbers.get("4089311627", include_carrier_info=True)
#print(number.national_format)  # => (510) 867-5309
#print(number.carrier['type'])
#print(number.carrier['name'])
#print(number.caller_name['caller_name'])

account_sid = "AC651584ed25ddcb8f2a6b686b27e2cba3"
auth_token = "8a1498fad6ad9300b30d94672e25364d"

media_url=['https://demo.twilio.com/owl.png', 'https://demo.twilio.com/logo.png']

client = TwilioRestClient(account_sid, auth_token)

message = client.messages.create(to="+14089311627", from_="+16509002030",
                                     body="Hello there! This is me again",
				     media_url=['https://demo.twilio.com/owl.png', 'https://demo.twilio.com/logo.png'])

#call = client.calls.create(to="+14089311627", from_="+16509002030", url="http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient")
call = client.calls.create(to="+14089311627", from_="+16509002030", url="https://www.starface.de/de/Service/moh/00_starface-music.wav")
print call.sid

