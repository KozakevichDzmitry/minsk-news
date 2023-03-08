jQuery(document).ready(function ($) {
    let connection = new autobahn.Connection({
        url: "wss://minsknews.by/socket/",
        // url: "ws://localhost:8888/socket/",
        realm: "realm1",
    });
    let newPostsId = {};
    let countKeys;
    let setTimeoutID= {};
    let delay=1000;
    const setCountNewPosts= (postID)=>{
        if(postID) newPostsId[postID.toString()]=true
        countKeys = Object.keys(newPostsId).length ||'';
        $("#added_news_counter").text(countKeys);
    }
    const addCass =(block, postID)=>{
        $(block).find(`[data-postid=${postID}]`).addClass('new-post')
    }
    const mouseenter = e => {
        const id = e.target.dataset.postid;
        if(setTimeoutID[`${id}`]) clearTimeout(setTimeoutID[`${id}`])
        setTimeoutID[`${id}`] = setTimeout(() => {
            document.querySelectorAll(`[data-postid="${id}"]`).forEach((elem)=>{
                elem.removeEventListener('mouseenter', mouseenter);
            })
            document.querySelectorAll(`[data-postid="${id}"]`).forEach((elem)=>{
                elem.removeEventListener('mouseleave', mouseleave);
            })
        delete newPostsId[id.toString()];
        setCountNewPosts()
    }, delay);}
    const mouseleave =e=>{
        const id = e.target.dataset.postid;
        clearTimeout(setTimeoutID[`${id}`]);}
    const removeListeners=()=>{
        for (let postID in newPostsId) {
            document.querySelectorAll(`[data-postid="${postID}"]`).forEach((elem)=>{
                elem.removeEventListener('mouseenter', mouseenter);
            })
            document.querySelectorAll(`[data-postid="${postID}"]`).forEach((elem)=>{
                elem.removeEventListener('mouseleave', mouseleave);
            })
        }
    }
    const addListeners=()=>{
        for (let postID in newPostsId) {
            document.querySelectorAll(`[data-postid="${postID}"]`).forEach((elem)=>{
                elem.addEventListener('mouseenter', mouseenter);
            })
            document.querySelectorAll(`[data-postid="${postID}"]`).forEach((elem)=>{
                elem.addEventListener('mouseleave', mouseleave);
            })
        }

    }

    connection.onopen = function (session) {

        session.subscribe("newspaper", (msg) => {
            const newspapersBlocks = JSON.parse(msg[0]);

            newspapersBlocks.tax.forEach((tax) => {
                let insertTo = $(`#main-content > div.pdf-attachments.${tax} .pdf-attachments-item[data-postid=${newspapersBlocks.postID}]`);
                if (insertTo.length === 0) {
                    insertTo = $(`#main-content > div.pdf-attachments.${tax}`);
                    insertTo.find(".pdf-attachments-item").last().remove();
                    insertTo.prepend($(newspapersBlocks.data));
                } else {
                    insertTo.replaceWith($(newspapersBlocks.data))
                }
            });
        });

        session.subscribe("news", (msg) => {
            removeListeners();
            const newsBlocks = JSON.parse(msg[0]);
            const postID= newsBlocks[0].postID

            newsBlocks.forEach((block) => {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = block.data;
                addCass(tempDiv, postID)
                if (block.cat === "glavnoe") {
                    let insertTo =$(`.glavnoe .news-template-line[data-postid=${block.postID}]`)
                    const parentBlock = $(".glavnoe")
                    if (insertTo.length === 0) {
                        $(parentBlock).children().last().remove()
                        parentBlock.prepend(tempDiv.innerHTML)
                    } else {
                        insertTo.replaceWith(tempDiv.innerHTML)
                    }
                }
                else if  (block.cat === "primary") {
                    const parentBlock= $(".primary")
                    parentBlock.addClass('new-post')
                    $(parentBlock).children('.news-template-image').replaceWith(tempDiv.innerHTML);
                }
                else if (block.cat === "main") {
                    let insertTo = $(`#main-content div.long-news-list .news-template-line[data-postid=${block.postID}]`);
                    const parentBlock = $(
                        "#main-content > div.main-news-cat.box-line-gap > div.long-news-list > #timeline-main-block"
                    )
                    if (insertTo.length === 0) {
                        parentBlock.prepend(tempDiv.innerHTML)
                    } else {
                        insertTo.replaceWith($(tempDiv.innerHTML))
                    }
                }
                else if (block.cat === "feed") {
                    let insertTo = $(`footer div.timeline__news-list-expanded .post-line[data-postid=${block.postID}]`);
                    const parentBlock = $("footer .timeline__news-list-expanded")
                    if (insertTo.length === 0) {
                        $(parentBlock).find(">:nth-child(3)").before(tempDiv.innerHTML)
                    } else {
                        insertTo.replaceWith($(tempDiv.innerHTML))
                    }
                    setCountNewPosts(postID)
                }
                else if (block.cat === "glavnoe-feed") {
                    let insertTo = $(`footer div.timeline__news-list-collapsed .timeline-news-template[data-postid=${block.postID}]`);
                    const parentBlock = $("footer div.timeline__news-list-collapsed")
                    if (insertTo.length === 0) {
                        $(parentBlock).find('>:last-child').remove()
                        $(parentBlock).prepend(tempDiv.innerHTML)
                    } else {
                        insertTo.replaceWith($(tempDiv.innerHTML))
                    }
                    setCountNewPosts(postID)
                }
                else {
                    tempDiv.querySelector(".topic-bar").remove();
                    $(`.box-column-gap.${block.cat}`).replaceWith(tempDiv.innerHTML)
                }
            });
            addListeners();
        });

        session.subscribe("district", (msg) => {
            const blockHtml = JSON.parse(msg[0]).data;
            const districts = JSON.parse(msg[0]).slug;
            const postID= JSON.parse(msg[0]).postID
            let tempDiv = document.createElement('div');
            districts.forEach((district) => {
                tempDiv.innerHTML = blockHtml;
                addCass(tempDiv, postID)
                $(`.district-preview > div.district-item.${district} .district-news`).replaceWith(tempDiv.innerHTML);
            });
        });

        session.subscribe("video", (msg) => {
            let tempDiv = document.createElement('div');
            const data = JSON.parse(msg[0]);
            const postID= data.postID
            const insertTo= $(`.video-news-template .box[data-postid=${postID}]`)
            const parentBlock = $(".video-news-template")

            tempDiv.innerHTML = data.data;
            addCass(tempDiv, postID)
            if (insertTo.length === 0) {
                $(parentBlock).children().last().remove()
                parentBlock.prepend(tempDiv.innerHTML)
            } else {
                insertTo.replaceWith(tempDiv.innerHTML)
            }
        });

        session.subscribe("authors_column", (msg) => {
            const data = JSON.parse(msg[0]);
            const toReplace = $(`.author-column-slider-card[data-id=${data['author_id']}] .content-container`);
            toReplace.replaceWith(data.data);

        });

        session.subscribe("event", (msg) => {
            const eventData = JSON.parse(msg[0]);
            $page = $("#events");
            $body = $("body");
            document.querySelector("#events div.event_slider");
            if ($page && $body.hasClass(`postid-${eventData.post_id}`)) {
                $("#events div.event_slider").slick("unslick");
                $("#events div.event_slider").replaceWith(eventData.data.slider);
                $("#events div.event_slider").slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1360,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                infinite: true,
                                dots: true,
                            },
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: "40px",
                                infinite: true,
                                slidesToShow: 1,
                                slidesToScroll: 1,
                            },
                        },
                    ],
                });
                $(`#events div.main-content > div.events-content`).replaceWith(
                    eventData.data.messages
                );
            }
        });
    };

    connection.open();
});
