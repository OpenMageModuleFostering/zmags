var publications = [];
var pubIds;
var appKey;
var baseUrl;
var requests = 0;


jQuery.ajaxSetup({
    cache: false,
    beforeSend:function(){
         requests++;
        // show gif here, eg:
        jQuery('#loading-mask').show();
    },
    complete:function(){

        requests--;
        if(requests==0)
        {
        // hide gif here, eg:
        jQuery('#loading-mask').hide();
        }
    }
});




/**
* Transform text into a URL slug: spaces turned into dashes, remove non alnum
* @param string text
*/
function slugify(str) {

    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
}

function loadPublications(url,key,base_url) {
    appKey = key;
    baseUrl = base_url;


    jQuery.getJSON(url, function(data) {

        if(!data.publicationIDs)
        {
            alert("Could not find any publications for this client on Zmags");
            return;
        }

        jQuery('#listtotal').html(data.publicationIDs.length);
        pubIds = chunk(data.publicationIDs,10);

        jQuery('#pagetotal').html(pubIds.length);
        if(pubIds.length > 0)
        {
            loadPage(0);
        }else{

            return;
        }

        jQuery('#next').click(function(){

            if(requests ==0){
            var currpage = parseInt(jQuery('#currpage').val())-1;
            var nextp = (currpage+1);
            loadPage(nextp);

            jQuery('#currpage').val(nextp+1);
            }
        });


        jQuery('#previous').click(function(){

            if(requests ==0){
            var currpage = parseInt(jQuery('#currpage').val())-1;
            var prevp = (currpage-1);

            loadPage(prevp);

            jQuery('#currpage').val(prevp-1);
            }
        });

    }   );



}


function loadPage(page)
{

    var pageitems = pubIds[page];

    jQuery("#publications_container").html('');

    jQuery.each(pageitems, function(index,v) {

        if(!publications[v])
        {
            loadPublicationInfo(v);
        }else{
            displayPublication(v);
        }

    });




}

function loadPublicationInfo(publication_id)
{


    if(!publications[publication_id])
    {
        var url = baseUrl+"/publication/"+publication_id+"?key="+appKey
        jQuery.getJSON(url, function(data){

            if(data.publicationDescriptor)
            {
                var baseUrl1 = data.baseURL;
                var bundlePath = data.publicationDescriptor.bundlePath;

                //console.log(data.publicationDescriptor.bundlePath);

                publications[publication_id] = { "publication_info": data, bundle_data: null, baseUrl: baseUrl1 };

                loadBundleData(baseUrl1,bundlePath,publication_id);
               // displayPublication(publication_id);
            }
        });
    }else{
        displayPublication(publication_id) ;
    }



}


function loadBundleData(baseUrl, bundlePath,publication_id)
{

    var bundleData;
    var url = baseUrl+bundlePath+"?key="+appKey;

    jQuery.getJSON(url,function(data){

        bundleData = data;

        publications[publication_id].bundle_data = bundleData;

        displayPublication(publication_id);

    });


}


function chunk (arr, len) {

    var chunks = [],
        i = 0,
        n = arr.length;

    while (i < n) {
        chunks.push(arr.slice(i, i += len));
    }

    return chunks;
}


function displayPublication(publication_id){

    var publication = publications[publication_id];

    //console.log(publication.publication_info);


    var title = publication.bundle_data.publicationDescriptor.name;
    var img = publication.baseUrl + publication.bundle_data[1].pageRepresentationDescriptors[0].pageRepresentation.resourcePath;

    //var item = jQuery('<div class="pubitem"><img src="'+img+'" /><p>'+title+'</p></div>');

    jQuery("#publications_container").append('<div id="'+publication_id+'" class="draggable"><div class="thumbnail well-nice"><a class="nailthumb-container" href="#"><img id="img_'+publication_id+'" class="nailthumb-image" src="'+img+'" /></a><p style="display:block;overflow: hidden; white-space: nowrap;text-align: center;">'+publication_id+'</p></div></div>');




    new Draggable(publication_id, {
        revert: true

        });
}

function findPubById(pub_id)
{



    var found = false;

    for(i=0; i<pubIds.length; i++)
    {
        var page_items = pubIds[i];

        if( page_items.indexOf(pub_id) )
        {
            found = true;
            break;
        }

    }


    if(!found || found=='-1')
    {
        alert('Unable to find publication with Pub ID:'+pub_id);
    } else{
        jQuery("#publications_container").html('');


        loadPublicationInfo (pub_id);
    }



}



