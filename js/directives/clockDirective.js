angular.module('dashboardApp').directive('clock', function() {
    return {
        restrict: 'EAC',
        scope: {
            width: '=',
            height: '=',
            type: '='
        },
        templateUrl: 'view/directives/clock.html',
        link: function() {
            init();

            /**
             * Creates objects for every clock hand and add to the canvas
             */
            function init() {
                var stage = new createjs.Stage("canvasClock");
                var offsetX = 20;
                var offsetY = 40;
                var sec = 1000;
                var min = sec * 60;
                var hour = min * 60;
                var now = moment.duration(moment().format('H:m:s'));

                var clock = new createjs.Bitmap('assets/clock.png');
                clock.x = offsetX;
                clock.y = offsetY;

                var hourHand = new createjs.Shape();
                hourHand.graphics.beginFill("#070707").drawRoundRect(253 + offsetX, 255 + offsetY, 176, 8, 0);
                hourHand.regX = 55 + 253 + offsetX;
                hourHand.regY = 4 + 255 + offsetY;
                hourHand.x = 253 + offsetX;
                hourHand.y = 255 + offsetY;
                hourHand.rotation = timeToDegree(now.asHours(), true);

                var minuteHand = new createjs.Shape();
                minuteHand.graphics.beginFill("#333").drawRoundRect(253 + offsetX, 255 + offsetY, 230, 8, 0);
                minuteHand.regX = 60 + 253 + offsetX;
                minuteHand.regY = 4 + 255 + offsetY;
                minuteHand.x = 253 + offsetX;
                minuteHand.y = 255 + offsetY;
                minuteHand.rotation = timeToDegree(now.minutes());

                var secondHand = new createjs.Bitmap('assets/second.png');
                secondHand.regX = 80;
                secondHand.regY = 4;
                secondHand.x = 253 + offsetX;
                secondHand.y = 255 + offsetY;
                secondHand.rotation = timeToDegree(now.seconds());

                stage.addChild(clock);
                stage.addChild(hourHand);
                stage.addChild(minuteHand);
                stage.addChild(secondHand);

                createjs.Tween.get(hourHand, {loop: true})
                    .to({rotation: hourHand.rotation + 360}, 12 * hour)
                ;
                createjs.Tween.get(minuteHand, {loop: true})
                    .to({rotation: minuteHand.rotation + 360}, 60 * min)
                ;

                createjs.Tween.get(secondHand, {loop: true})
                    .to({rotation: secondHand.rotation + 360}, 60 * sec)
                ;

                createjs.Ticker.setFPS(24);
                createjs.Ticker.addEventListener("tick", stage);
            }

            /**
             * Change a minute/hour value into an angle
             * @param time
             * @param isHour
             * @returns {*}
             */
            function timeToDegree(time, isHour)
            {
                var factor = (angular.isDefined(isHour) && isHour == true) ? 30 : 6;
                var value = (time * factor) -90;
                return oneTo360(value);
            }

            /**
             * Change a value into an angle
             * @param degree
             * @returns {*}
             */
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