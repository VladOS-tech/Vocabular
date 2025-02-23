import TagObject from "./TagObject";
import MeaningObject from "./MeaningObject";

interface PhraseObject extends MeaningObject, TagObject{
    id: number,
    date: Date,
    phrase: string,
    tags: TagObject[],
    meanings: MeaningObject[]
}

export default PhraseObject;