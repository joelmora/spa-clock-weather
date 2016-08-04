app.directive('clock', function() {
    return {
        restrict: 'EAC',
        scope: {
            width: '=',
            height: '=',
            type: '='
        },
        templateUrl: 'view/directives/clock.html',
        link: function(scope) {
            init();

            function init() {
                var stage = new createjs.Stage("canvasClock");
                var canvasWidth = scope.width;
                var canvasHeight = scope.height;
                var canvasWidthH = canvasWidth / 2;
                var canvasHeightH = canvasHeight / 2;
                var sec = 1000;
                var min = sec * 60;
                var hour = min * 60;
                var now = moment();

//            console.debug(now.toString())
//            console.debug(timeToDegree(1, true))


                var clockBorder = new createjs.Shape();
                clockBorder.graphics.setStrokeStyle(8,"round").beginStroke("#333").drawCircle(canvasWidthH, canvasHeightH, canvasWidthH);

                var clockMiddle = new createjs.Shape();
                clockMiddle.graphics.beginFill("#000").drawCircle(canvasWidthH, canvasHeightH, 10);

                var hourHand = new createjs.Shape();
                hourHand.graphics.beginFill("#000").drawRoundRect(canvasWidthH, canvasHeightH, canvasWidthH * 0.5, 10, 3);
                hourHand.regX = hourHand.x = hourHand.y = canvasWidthH;
                hourHand.regY = canvasWidthH + 5;
                hourHand.rotation = timeToDegree(now.hours(), true);

                var minuteHand = new createjs.Shape();
                minuteHand.graphics.beginFill("#555").drawRoundRect(canvasWidthH, canvasHeightH, canvasWidthH * 0.7, 7, 3);
                minuteHand.regX = minuteHand.x = minuteHand.y = canvasWidthH;
                minuteHand.regY = canvasWidthH + 3.5;
                minuteHand.rotation = timeToDegree(now.minutes());

//            var secondHand = new createjs.Bitmap('http://paulrhayes.com/experiments/clock/images/minuteHand.png');
                var secondHand = new createjs.Shape();
                secondHand.graphics.beginFill("#999").drawRoundRect(canvasWidthH, canvasHeightH, canvasWidthH * 0.9, 4, 3);
                secondHand.regX = secondHand.x = secondHand.y = canvasWidthH;
                secondHand.regY = canvasWidthH + 2;
                secondHand.rotation = timeToDegree(now.seconds());

                stage.addChild(clockBorder);
                stage.addChild(hourHand, minuteHand, secondHand);
                stage.addChild(clockMiddle);

                createjs.Tween.get(hourHand, {loop: true})
                    .to({rotation: hourHand.rotation + 360}, 12 * hour)
                ;
                createjs.Tween.get(minuteHand, {loop: true})
                    .to({rotation: minuteHand.rotation + 360}, 60 * min)
                ;

                var angle = 0
                createjs.Tween.get(secondHand, {loop: true})
                    .to({rotation: secondHand.rotation + 360}, 60 * sec)
                ;

                createjs.Ticker.setFPS(24);
                createjs.Ticker.addEventListener("tick", stage);
            }

            function timeToDegree(time, isHour)
            {
                var factor = (typeof isHour != 'undefined' && isHour == true) ? 30 : 6;
                var value = (time * factor) -90;
                return oneTo360(value);
            }

            function oneTo360(degree)
            {
                if (degree < 0) {
                    return 360 + degree;
                } else
                if (degree > 360) {
                    return degree - 360;
                } else
                    return degree;
            }
        }
    };
});