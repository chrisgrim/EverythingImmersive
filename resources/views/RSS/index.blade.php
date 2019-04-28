<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">




	<div><b>Show Name=</b> {{$event->eventTitle}}</div><br>
	<div><b>Production Company=</b> {{$event->organizer->organizationName}}</div><br>
	<div><b>Regions=</b>
		@foreach($regions as $region)
			{{$region->region}}
		@endforeach
	</div><br>
	<div><b>Opening Date=</b>{{$event->openingDate}}</div><br>
	<div><b>Closing Data=</b>{{$event->closingDate}}</div><br>
	<div><b>Location=</b>{{$event->eventStreetAddress}}{{$event->eventCity}}{{$event->eventState}}{{$event->eventCountry}}{{$event->eventZipcode}}</div><br>
	<div><b>General Price=</b>{{$event->eventGeneralCost}}</div><br>
	<div><b>Student Price=</b>{{$event->eventStudentCost}}</div><br>
	<div><b>Senior Price=</b>{{$event->eventSeniorCost}}</div><br>
	<div><b>VIP Price=</b>{{$event->eventVIPCost}}</div><br>
	<div><b>Military Price=</b>{{$event->eventMilitaryCost}}</div><br>
	<div><b>Age Restriction=</b>{{$event->ageRestriction}}</div><br>
	<div><b>Category=</b>{{$event->category->categoryName}}</div><br>
	<div><b>Event Description=</b>{{$event->eventDescription}}</div><br>
	<div><b>Genres=</b>
		@foreach($genres as $genre)
			{{$genre->genre}}
		@endforeach
	</div><br>
	<div><b>Level Of Contact=</b>
		@foreach($contactLevels as $ContactLevel)
			{{$ContactLevel->level}}
		@endforeach
	</div><br>
	<div><b>Advisory for sexual Violence= </b>{{$event->sexualViolence}}</div><br>
	<div><b>Content Advisories= </b>{{$event->contentAdvisories}}</div><br>
	<div><b>Wheel Chair Accessible?= </b>{{$event->wheelchairReady}}</div><br>
	<div><b>Mobility Advisories= </b>{{$event->mobilityAdvisories}}</div><br>
	<div><b>Event Link= </b>{{$event->eventWebsite}}</div><br>
	<div><b>Ticket Link= </b>{{$event->eventTicketUrl}}</div><br>
	<div><b>Company Website= </b>{{$event->organizer->organizationWebsite}}</div><br>
	<div><b>Instagram Handle= </b>{{$event->organizer->instagramHandle}}</div><br>
	<div><b>Twitter Handle= </b>{{$event->organizer->twitterHandle}}</div><br>
	<div><b>Facebook Handle= </b>{{$event->organizer->facebookHandle}}</div><br>
	<div><b>Primary Contact Name= </b>{{$event->user->name}}</div><br>
	<div><b>Primary Contact Email= </b>{{$event->user->email}}</div><br>


</rss>